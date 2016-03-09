<?php

namespace App\Http\Controllers;

use Log;
use Cache;
use Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Partner;
use Symfony\Component\HttpFoundation\Response as Response;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

define('CP_PARTNERS_COL', 'partners');
define('CP_TRAVEL_OFFERS_COL', 'travel_offers');
define('CP_QUOTES_REF', 'quotes');
define('CP_POLICIES', 'policies');
define('CP_TRAVEL_PROMO_CODE', 'travel_promo');
define('OFFERS_STD_PARTNER', 'STD');
    // define('EXCEL_DIR', './excels');
    
class RequestCtrl extends BaseController
{
    protected $data = null;
    protected $response=null;
    protected $quote_doc = array();
    protected $response_doc = array();
    protected $quoteRequestDate = null;
    protected $quote_ref;
    protected $ResponseSaved = false;

    public function request(Request $request, $parter_id, $request_id, $force_create_new_quote_log = false)
    {
        if (!$parter_id) {
            $parter_id = $request->input('customer_id');
        }

        if (!$request_id) {
            $request_id = $request->input('request_id');
        }
        
        $data = null;
        $this->path = $request->decodedPath();

        // celowe przekształcanie na tablicę, ze względu na wydajność i możliwość walidowania przez framework
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            abort(Response::HTTP_BAD_REQUEST);
        }
        
        $this->partnerCode = $parter_id;
        $this->request_id = $request_id;
        /*utworzenie obiektu partnera. Jeśli nie znaleziony, to komunikat błędu*/
        $this->partner = new  \App\Http\Partner($parter_id, 'travel');
        if (!$this->partner->isAuth()) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        $this->partnerCode = $this->partner->getCode();
        $this->data = $data;
        
        $this->quoteLog($force_create_new_quote_log);
        
        
        if ($this->partner->isAuth()) {
            //$collection = $this->mongoDB->selectCollection(CP_QUOTES_REF);
            $this->quote_doc[$this->path][$this->quoteRequestDate]['response_time'] = $this->getTime();
            $this->quote_doc[$this->path][$this->quoteRequestDate]['response'] = $this->response_doc;
            unset($this->quote_doc['quote_ref']);

            $result = app('db')->collection(CP_QUOTES_REF)->
                where('_id', $this->quote_doc['_id'])->update($this->quote_doc);
        }
    }
    /**
     * Metoda zapisuje do bazy odpowiedz przekazana klientowi.
     * Dopisuje przy tym response_doc do istniejącego quote_doc
     */
    public function destruct()
    {
        // Nie używajmy destruktora w celu logowania i innych ważnych działań
        // Sprawdzanie czy partner jest zautoryzowany tylko w celu ominięcia błędu
        // Gdy środowisko jest produkcyjne destruktor uruchamia się razem
        // z Garbage Collector np. gdy partner nie jest autoryzowany
        // a destruktor próbuje coś logować
        if ($this->ResponseSaved) {
            return;
        }
        
        if(is_object($this->partner) && $this->partner->isAuth()) {
//            $collection = $this->mongoDB->selectCollection(CP_QUOTES_REF);
            $this->quote_doc[$this->path][$this->quoteRequestDate]['response_time'] = $this->getTime();
            $this->quote_doc[$this->path][$this->quoteRequestDate]['response'] = $this->response_doc;
            unset($this->quote_doc['quote_ref']);
            $result = app('db')->collection(CP_QUOTES_REF)->
                where('_id', $this->quote_doc['_id'])->update($this->quote_doc);
        }
    }
    
    public function endLogSave()
    {


        if ($this->partner->isAuth()) {

            $this->quote_doc[$this->path][$this->quoteRequestDate]['response_time'] = $this->getTime();
            $this->quote_doc[$this->path][$this->quoteRequestDate]['response'] = $this->response_doc;
            unset($this->quote_doc['quote_ref']);
            $result = app('db')->collection(CP_QUOTES_REF)->
                where('_id', $this->quote_doc['_id'])->update($this->quote_doc);
        }
        $this->ResponseSaved = true;
    }
    
    /**
     * Pobieranie Quote na podstawie id lub tworzenie nowego rekordu gdy nie znaleziono pasującego
     *
     * Jeśli przekazano w zapytaniu quote_ref i istnieje w bazie zapis o takim _id,
     * metoda pobiera z bazy istniejący dokument. W przeciwnym wypadku usiłuje go stworzyć.
     * Jeśli przekazano błędny quote_ref lub w bazie istnieje więcej niż jeden rekord
     * o danym ID (praktycznie nie możliwe)
     * Zwracany jest komunikat błędu.
     *
     */
    protected function quoteLog($force_create_new_quote_log = false)
    {
        $this->quote_doc = array();
        $this->quoteRequestDate = $this->getTime();
        if (!empty($this->data['quote_ref'])) {
            $this->quote_ref=$this->data['quote_ref'];
        } elseif (!empty($this->data['request']['quote_ref'])) {
            $this->quote_ref=$this->data['request']['quote_ref'];
        }
        if (!empty($this->quote_ref) && !$force_create_new_quote_log) {
            
            $dbRef = substr($this->quote_ref, 0, 24);
            $data = app('db')->collection(CP_QUOTES_REF)->find($dbRef);

            if (empty($data)) {
                abort(Response::HTTP_NOT_ACCEPTABLE);
            } else {
                $this->quote_doc = $data;//json_decode(json_encode($res),TRUE);
                $this->quote_doc[$this->path][$this->quoteRequestDate]['request'] = $this->data;
            }

        } else {
            $this->quote_doc['partnerCode'] = $this->partnerCode;
            $this->quote_doc['path'] = $this->path;
            $this->quote_doc[$this->path][$this->quoteRequestDate]['esb_id'] = $this->request_id;
            $this->quote_doc[$this->path][$this->quoteRequestDate]['request'] = $this->data;
            //$resp = $collection->insert($this->quote_doc,array('w'));
            
            $id = app('db')->collection(CP_QUOTES_REF)->insertGetId($this->quote_doc);
           
            $this->quote_doc['_id'] = $id;
        }
        
        $this->quote_doc['quote_ref'] = $this->quote_doc['_id']->__toString();

    }
    /**
     *
     * Wstawia do rekordu w quotes parę klucz wartość. Jeśli klucz istnieje,
     * a nie ustawiono parametru zwróci false. W wypadku powodzenia zwróci true.
     * @param string $key nazwa parametru do wstawienia
     * @param mixed $value wartosc parametru do wstawienia
     * @param boolean $doReplace Czy w jeśli parametr istnieje ma go zamienic - domyslnie false
     * @return boolean true w wypadku powodzenia
     */
    protected function quoteLogAdd($key, $value, $doReplace = false)
    {
        if (empty($this->quote_doc[$key])||($doReplace)) {
            $this->quote_doc[$key] = $value;
            return true;
        }
        return false;
    }
    
    protected function quoteLogGetValue($key)
    {
        if (!empty($this->quote_doc[$key])) {
            return $this->quote_doc[$key];
        } else {
            return false;
        }
    }

    /**
    * Metoda zwraca sformatowany znacznik czasu
    */
    private function getTime()
    {
        return \DateTime::createFromFormat('U.u', microtime(true))->format("YmdHisu");
    }
    
    public static function mongoCursorToarray($object)
    {
        if (is_a($object, '\MongoDB\BSON\ObjectId')) {
            return $object;
        } else {
            if (is_array($object) || is_object($object)) {
                $result = array();
                foreach ($object as $key => $value) {
                    $result[$key] = RequestCtrl::mongoCursorToarray($value);
                }
                return $result;
            }
            return $object;
        }
    }
}

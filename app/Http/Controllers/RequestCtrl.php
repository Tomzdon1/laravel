<?php

namespace App\Http\Controllers;
use Log;
use Cache;
use Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Partner;
use Symfony\Component\HttpFoundation\Response as Response;


    
    define('CP_PARTNERS_COL','partners');
    define('CP_TRAVEL_OFFERS_COL','travel_offers');
    define('CP_QUOTES_REF','quotes');
    define('CP_POLICIES','policies');
    define('CP_TRAVEL_PROMO_CODE','travel_promo');
    define('OFFERS_STD_PARTNER','STD');
    // define('EXCEL_DIR','./excels');
    
class RequestCtrl extends BaseController
{
    protected $data = null;
    protected $response=null;
    protected $quote_doc = Array();
    protected $response_doc = Array();
    protected $quoteRequestDate = null;
    protected $quote_ref;

    public function request(Request $request,  $parter_id, $request_id, $force_create_new_quote_log = false)
    {
        \Log::debug('Request ' . $request);

        $this->mongoClient = new \MongoClient("mongodb://" . env('MONGO_SRV') . ":" . env('MONGO_PORT'));
        $this->mongoDB = $this->mongoClient->selectDB(env('MONGO_CP_DB'));
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
        $this->partner = new  \App\Http\Partner($parter_id,'travel');
        if(!$this->partner->isAuth()) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        $this->partnerCode = $this->partner->getCode();
        $this->data = $data;
        
        $this->quoteLog($force_create_new_quote_log);
        
    }
    /**
     * Metoda zapisuje do bazy odpowiedz przekazana klientowi.
     * Dopisuje przy tym response_doc do istniejącego quote_doc
     */
    public function __destruct() {

        // Nie używajmy destruktora w celu logowania i innych ważnych działań
        // Sprawdzanie czy partner jest zautoryzowany tylko w celu ominięcia błędu
        // Gdy środowisko jest produkcyjne destruktor uruchamia się razem z Garbage Collector np. gdy partner nie jest autoryzowany
        // a destruktor próbuje coś logować
        if(is_object($this->partner) && $this->partner->isAuth()) {
            $collection = $this->mongoDB->selectCollection(CP_QUOTES_REF);
            $this->quote_doc[$this->path][$this->quoteRequestDate]['response_time'] = $this->getTime();
            $this->quote_doc[$this->path][$this->quoteRequestDate]['response'] = $this->response_doc;
            unset($this->quote_doc['quote_ref']);
            $collection->update(['_id'=>$this->quote_doc['_id']],$this->quote_doc);
        }
    }
    
    /**
     * Pobieranie Quote na podstawie id lub tworzenie nowego rekordu gdy nie znaleziono pasującego
     *
     * Jeśli przekazano w zapytaniu quote_ref i istnieje w bazie zapis o takim _id,
     * metoda pobiera z bazy istniejący dokument. W przeciwnym wypadku usiłuje go stworzyć.
     * Jeśli przekazano błędny quote_ref lub w bazie istnieje więcej niż jeden rekord o danym ID (praktycznie nie możliwe)
     * Zwracany jest komunikat błędu.
     * 
     */
    protected function quoteLog($force_create_new_quote_log = false){
        $this->quote_doc = Array();
        $collection = $this->mongoDB->selectCollection(CP_QUOTES_REF);


        $this->quoteRequestDate = $this->getTime();
        if(!empty($this->data['quote_ref']))
            $this->quote_ref=$this->data['quote_ref'];
        elseif(!empty($this->data['request']['quote_ref']))
            $this->quote_ref=$this->data['request']['quote_ref'];
        
        Log::info(print_r($this->quote_ref,1));
        
        if(!empty($this->quote_ref) && !$force_create_new_quote_log){
             
            $dbRef = substr($this->quote_ref, 0,24);
            $cursor = $collection->find(Array('_id'=>new \MongoId($dbRef) ) );
            $cnt = $cursor->count();
            if($cnt!=1){
                if($cnt==0){ abort(Response::HTTP_NOT_ACCEPTABLE);}
                elseif($cnt>1){ abort(Response::HTTP_INTERNAL_SERVER_ERROR);}
            }
            else{
                $res = iterator_to_array($cursor);
                reset($res);
                $this->quote_doc = current($res);
                $this->quote_doc[$this->path][$this->quoteRequestDate]['request'] = $this->data;
            }
        }else{
            $this->quote_doc['partnerCode'] = $this->partnerCode;
            $this->quote_doc['path'] = $this->path;
            $this->quote_doc[$this->path][$this->quoteRequestDate]['esb_id'] = $this->request_id;
            $this->quote_doc[$this->path][$this->quoteRequestDate]['request'] = $this->data;
            $resp = $collection->insert($this->quote_doc,array('w'));
        }
        $this->quote_doc['quote_ref'] = $this->quote_doc['_id']->__toString();
        
    }
    /**
     * 
     * Wstawia do rekordu w quotes parę klucz wartość. Jeśli klucz istnieje, a nie ustawiono parametru zwróci false. W wypadku powodzenia zwróci true.
     * @param string $key nazwa parametru do wstawienia
     * @param mixed $value wartosc parametru do wstawienia
     * @param boolean $doReplace Czy w jeśli parametr istnieje ma go zamienic - domyslnie false
     * @return boolean true w wypadku powodzenia
     */
    protected function quoteLogAdd($key,$value,$doReplace=false){
        if(empty($this->quote_doc[$key])||($doReplace)){
            $this->quote_doc[$key] = $value;
            return true;
        }
        return false;
    }
    
    protected function quoteLogGetValue($key){
        if(!empty($this->quote_doc[$key]))
            return $this->quote_doc[$key];
        else 
            return false;    
    }

    /**
    * Metoda zwraca sformatowany znacznik czasu
    */
    private function getTime() {
        return \DateTime::createFromFormat('U.u', microtime(true))->format("YmdHisu");
    }
}

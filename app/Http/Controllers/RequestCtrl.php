<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Partner;
use Symfony\Component\HttpFoundation\Response as Response;

define('CP_PARTNERS_COL', 'partners');
define('CP_TRAVEL_OFFERS_COL', 'travel_offers');
define('CP_QUOTES_REF', 'quotes');
define('CP_POLICIES', 'policies');
define('CP_TRAVEL_PROMO_CODE', 'travel_promo');
define('OFFERS_STD_PARTNER', 'STD');
    
class RequestCtrl extends BaseController
{
    protected $data = null;
    protected $response=null;
    protected $quote_doc = array();
    protected $response_doc = array();
    protected $quoteRequestDate = null;
    protected $quote_ref;

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
    }
    
    /**
     * FUNKCJA PRZEZNACZONA DO USUNIĘCIA, POZOSTAWIONA TYLKO Z POWODU WIELU WYWOŁAŃ
     * 
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
        dd($data);

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
            
            // $id = app('db')->collection(CP_QUOTES_REF)->insertGetId($this->quote_doc);
           
            // $this->quote_doc['_id'] = $id;
        }
        

        if (isset($this->quote_doc['_id'])) {
            $this->quote_doc['quote_ref'] = $this->quote_doc['_id']->__toString();
        } else if (app('request')->attributes->has('requestId')) {
            $this->quote_doc['_id'] = app('request')->attributes->get('requestId');
        }
        
    }

    /**
     * FUNKCJA PRZEZNACZONA DO USUNIĘCIA, POZOSTAWIONA TYLKO Z POWODU FUNKCJI quoteLog
     * 
     * Metoda zwraca sformatowany znacznik czasu
     */
    private function getTime()
    {
        return \DateTime::createFromFormat('U.u', sprintf("%.6F", microtime(true)))->format("YmdHisu");
    }
}

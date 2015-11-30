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
    define('OFFERS_STD_PARTNER','STD');
    define('EXCEL_DIR','./excels');       
    
class RequestCtrl extends BaseController
{
    var $data, $response=null;
    var $quote_doc = Array();
    var $response_doc = Array();
    public function request(Request $request,  $parter_id, $request_id, $force_create_new_quote_log = false)
    {       
        $data = null;
        $this->path = $request->decodedPath();

        if ($request->has('data')) {
          // celowe przekształcanie na tablicę, ze względu na wydajność i możliwość walidowania przez framework
          $data = json_decode($request->input('data'), true);
        }

        if ($data === null) {
          abort(Response::HTTP_BAD_REQUEST);
        }
        
        $this->partnerCode = $parter_id;
        $this->request_id = $request_id;
        /*utworzenie obiektu partnera. Jeśli nie znaleziony, to komunikat błędu*/
        $this->partner = new  \App\Http\Partner($parter_id,'travel');
        if(!$this->partner->isAuth()) {
            abort(Response::HTTP_FORBIDDEN);
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
        $collection = $this->mongoDB->selectCollection(CP_QUOTES_REF);
        
        $this->quote_doc[$this->path][$this->quoteRequestDate]['response_time'] = $this->getTime();
        $this->quote_doc[$this->path][$this->quoteRequestDate]['response'] = $this->response_doc;
        unset($this->quote_doc['quote_ref']);
        $collection->update(Array('_id'=>$this->quote_doc['_id']),$this->quote_doc);
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
        
        if(!empty($this->data['quote_ref']) && !$force_create_new_quote_log){
            $dbRef = substr($this->data['quote_ref'], 0,24);
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
    * Metoda zwraca sformatowany znacznik czasu
    */
    private function getTime() {
        return \DateTime::createFromFormat('U.u', microtime(true))->format("YmdHisu");
    }
}

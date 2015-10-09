<?php

namespace App\Http\Controllers;
use Log;
use Cache;
use Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Partner;
use Symfony\Component\HttpFoundation\Response as Response;

define('MONGO_SRV','192.168.7.60');
    define('MONGO_PORT','27017');
    define('MONGO_CP_DB','Ceper');
    
    define('CP_PARTNERS_COL','partners');
    define('CP_TRAVEL_OFFERS_COL','travel_offers');
    define('OFFERS_STD_PARTNER','STD');
    define('EXCEL_DIR','./excels');

class RequestCtrl extends BaseController
{
    var $data, $response=null;
    public function request(Request $request,  $parter_id, $request_id)
    {
        $data = null;

        if ($request->has('data')) {
          // celowe przekształcanie na tablicę, ze względu na wydajność i możliwość walidowania przez framework
          $data = json_decode($request->input('data'), true);
        }

        if ($data === null) {
          //skorzystać z kodów w Response jezeli bedziemy zwracac kody http bezposrednio (a nie np. w jsonie zawsze z http 200 ok)
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
        
    }
}

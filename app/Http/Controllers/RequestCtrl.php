<?php

namespace App\Http\Controllers;
use Log;
use Cache;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Partner;
use Symfony\Component\HttpFoundation\Response as Response;

class RequestCtrl extends Controller
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

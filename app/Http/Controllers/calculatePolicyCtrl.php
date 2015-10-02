<?php

namespace App\Http\Controllers;
use Log;
use Cache;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestCtrl;
use Illuminate\Http\Request;


//TODO Przeniesc do konfiguracji //
    define('MONGO_SRV','localhost');
    define('MONGO_PORT','27017');
    define('MONGO_CP_DB','Ceper');
    
    define('CP_PARTNERS_COL','partners');
    define('CP_TRAVEL_OFFERS_COL','travel_offers');
    define('OFFERS_STD_PARTNER','STD');
    define('EXCEL_DIR','./excels');
    // define('EXCEL_DIR','/mnt/ramdisk');


class calculatePolicyCtrl extends RequestCtrl{
var $partner;
  
  public function request(Request $request,  $parter_id, $request_id)
  {
     
    if($rsp=parent::request($request,  $parter_id, $request_id))
        return $rsp;
    
    $this->response = ['status'=>'OK','data'=>''];
    return response()->json($this->response);
  }
  
    
}

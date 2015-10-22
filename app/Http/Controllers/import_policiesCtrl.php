<?php

namespace App\Http\Controllers;
use Log;
use Cache;
use Validator;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestCtrl;
use Illuminate\Http\Request;
use App\apiModels\travel\PolicyData;
use App\apiModels\travel\v1\prototypes\CALCULATE_REQUEST_impl;

use Symfony\Component\HttpFoundation\Response as Response;


class import_policiesCtrl extends RequestCtrl{
var $partner;
  
  public function request(Request $request,  $parter_id, $request_id)
  {
     
    parent::request($request, $parter_id, $request_id);
    
    $this->objSer = new \App\apiModels\ObjectSerializer();
        $this->quote_request = $this->objSer->deserialize($this->data, '\App\apiModels\travel\v1\prototypes\IMPORTREQUEST');

    $this->response = $this->savePolicy($this->data);
    
    return $this->response;
  }
  
  private function savePolicy($data)
  {
      $this->policy_doc = $data;
      $this->policy_doc['partnerCode'] = $this->partnerCode;
      $this->policy_doc['quoteRef'] = $this->quote_doc['quote_ref'];
      $collection = $this->mongoDB->selectCollection(CP_POLICIES);
      
      $resp = $collection->insert($this->policy_doc,array('w'));
  }
    
}

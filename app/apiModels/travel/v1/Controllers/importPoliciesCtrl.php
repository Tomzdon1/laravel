<?php

namespace App\apiModels\travel\v1\Controllers;
use Log;
use Cache;
use Validator;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestCtrl;
use Illuminate\Http\Request;
use App\apiModels\travel\PolicyData;
use App\apiModels\travel\v1\prototypes\IMPORTREQUEST_impl;

use Symfony\Component\HttpFoundation\Response as Response;


class importPoliciesCtrl extends RequestCtrl{
var $partner;
  
  public function request(Request $request,  $parter_id = null, $request_id = null,$create_new_quote_log = null)
  {
    parent::request($request, $parter_id, $request_id);

    //foreach($this->data as $dt){
    $this->objSer = new \App\apiModels\ObjectSerializer();
        $this->quote_request = $this->objSer->deserialize($this->data, '\App\apiModels\travel\v1\prototypes\IMPORTREQUEST');
    //}
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

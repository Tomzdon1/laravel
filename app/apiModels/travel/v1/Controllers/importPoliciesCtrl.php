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
  
  public function request(Request $request, $parter_id = null, $request_id = null, $create_new_quote_log = null)
  {
    parent::request($request, $parter_id, $request_id);

    $this->objSer = new \App\apiModels\ObjectSerializer();
    $this->importRequests = [];
  
    foreach ($this->data as $policy) { 
      $this->importRequests[] = $this->objSer->deserialize($policy, '\App\apiModels\travel\v1\prototypes\IMPORTREQUEST');
      $this->response[] = $this->savePolicy($policy);
    }

    return $this->response;
  }
  
  // Ta funkcja powinna być w klasie IMPORTREQUEST
  private function savePolicy($data)
  {
    $status = 'OK';
    $messages = Array();
    $policyId = '';
    
    $product_ref =   $data['product_ref'];
    $policyData = [];
    $policyData['request'] = Array(
      'data'=>$data['data'],
      'policy_holder'=>$data['policy_holder'],
      'insured'=>$data['insured']
    );
    
    $policyData['request']['data']['destination']=(!empty($data['data']['destination']))?$data['data']['destination']:'';
    $policyData['amount'] = $data['amount'];
    $policyData['request']['quote_ref'] = $this->quote_doc['quote_ref'];
     
    $policyM = new \App\apiModels\travel\PolicyModel($this->mongoDB);
    $policyPrint = $policyM->setPolicy($product_ref, $policyData,  $this->partner);
// Mozliwe, że model polisy powinien byc spojny dla roznych typow
// Trzeba zdecydowac, czy walidacje maja się odbywac w kontrolerze, czy raczej w modelu
// mysle, ze powinny byc w policy model, w takim wypadku status i message's powinny przychodzic z modelu
// $status = $policyM->getStatus();
// $messages = $policyM->getMessages();
// w przeciwnym powinny byc w nim ustawiane
// $policyM->setStatus($status);
// $policyM->getMessages($messages);    
    
    $policyCollection = $this->mongoDB->selectCollection(CP_POLICIES);
    $policyCollection->insert($policyPrint,array('w'));
    $policyId = (string)$policyPrint["_id"];
    
    
    $policyDate = date('Y-m-d h:i:s');
    
    $this->quoteLogAdd('policyId',$policyId);
    $this->quoteLogAdd('policyDate',$policyDate);
    
    
    //Po wygenerowaniu modelu zawierającego IMPORT_STATUS należy refaktoryzować na model
    return Array('status'=>$status,'policy_ref'=>$policyId,'messages'=>$messages);
  }
    
}

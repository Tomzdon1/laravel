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
    foreach($this->data as $policy)    
        $this->response[] = $this->savePolicy($policy);
    
    return $this->response;
  }
  
  private function savePolicy($data)
  {
    
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
    
    
    $policyCollection = $this->mongoDB->selectCollection(CP_POLICIES);
    $policyCollection->insert($policyPrint,array('w'));
    $policyId = (string)$policyPrint["_id"];
    
    Log::info('totuuu'.print_r($policyPrint,1));
    
    //$policyId = '0011';
    $policyDate = date('Y-m-d h:i:s');
    
    $this->quoteLogAdd('policyId',$policyId);
    $this->quoteLogAdd('policyDate',$policyDate);
    /*
      
      $this->policy_doc = $data;
      $this->policy_doc['partnerCode'] = $this->partnerCode;
      $this->policy_doc['quoteRef'] = $this->quote_doc['quote_ref'];
      $collection = $this->mongoDB->selectCollection(CP_POLICIES);
      
      $resp = $collection->insert($this->policy_doc,array('w'));
     * 
     */
    
  }
    
}

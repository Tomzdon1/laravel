<?php

namespace App\apiModels\travel;

class PolicyModel
{
    var $productRef;
    var $policyData;
    var $mongoDB;
    var $amount;
    var $partner;
    var $product;
    
    public function __construct($mongoDB){
        $this->mongoDB = $mongoDB;
    }
    
    public function setPolicy($product_ref,$policyData,$sourceQuote,$partner) {
        $this->productRef = $product_ref;
        $this->policyData = $policyData['data']['request'];
        $this->amount = $policyData['data']['amount'];
        $this->product = $this->getProduct($this->productRef);
        $this->partner = $partner;
        $this->partnerData = $this->partner->getPartnerData();
        return $this->getPolicy();
    }
    
    public function getProduct($productRef){
        $collection = $this->mongoDB->selectCollection(CP_TRAVEL_OFFERS_COL);
        $m1 = new \MongoId($productRef);
        $product = $collection->findOne(Array('_id'=>$m1));
        return $product;
    }
    
    private function getPolicy(){
        
        $policy = Array();
        $policy['quote_ref']    = $this->policyData['quote_ref'];
        $policy['start_date']   = $this->policyData['data']['start_date'];
        $policy['end_date']     = $this->policyData['data']['end_date'];
        $policy['abroad']       = $this->policyData['data']['abroad'];
        $policy['destination']  = $this->policyData['data']['destination'];
        $policy['policy_holder']= $this->policyData['policy_holder'];
        $policy['insured']      = $this->policyData['insured'];
        
        $policy['amount']['value_base']   = $this->amount['value_base'];
        $policy['amount']['value_base_currency'] = $this->amount['value_base_currency'];
        $policy['amount']['value']        = $this->amount['value'];
        $policy['amount']['value_currency']= $this->amount['value_currency'];
        $policy['amount']['currency_rate']= $this->amount['currency_rate'];
        $policy['amount']['date_rate']    = $this->amount['date_rate'];
        
        $policy['partner']['code']          = $this->partnerData['code'];
        $policy['partner']['customerId']    = $this->partnerData['customerId'];
        $policy['partner']['travel_api']    = $this->partnerData['apis']['travel']['version'];
        $policy['product']['code']      = $this->product['code'];
        
        $policy['product']['elements'] = [];
        foreach($this->product['elements'] as $elem){
            $policy['product']['elements'][] = Array(
                                                'kube'=>$elem['kube'],
                                                'su'=>$elem['value'],
                                                'currency'=>$elem['currency'],
                                                'division'=>$elem['division']
                                                );
        }
        $policy['product']['options'] = [];
        foreach($this->policyData['data']['option_values'] as $option){
            if($option['value']==true){
                foreach($this->product['options'] as $prodOpt){
                    if($prodOpt['code']==$option['code']){
                        $policy['product']['options'][] = Array(
                                                            'code'      =>$option['code'],
                                                            'tuecode'   =>$prodOpt['tucode']
                        );
                    }
                }
            }
                
        }
        return $policy;
    }
}
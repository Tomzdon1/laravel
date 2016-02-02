<?php

namespace App\apiModels\travel;

use App\Events\IssuedPolicyEvent;

class PolicyModel implements \JsonSerializable
{
    public $productRef;
    public $policyData;
    public $mongoDB;
    public $amount;
    public $partner;
    public $product;

    public $policyId = null;
    
    public function __construct($mongoDB)
    {
        $this->mongoDB = $mongoDB;
    }

    public function jsonSerialize()
    {
        return $this->getPolicy();
    }
    
    public function setPolicy($product_ref, $policyData, $partner)
    {
        $this->productRef = $product_ref;
        $this->policyData = $policyData['request'];
        $this->amount = $policyData['amount'];
        $this->product = $this->getProduct($this->productRef);
        $this->partner = $partner;
        $this->partnerData = $this->partner->getPartnerData();
        return $this->getPolicy();
    }
    
    public function getProduct($productRef)
    {
        $collection = $this->mongoDB->selectCollection(CP_TRAVEL_OFFERS_COL);
        $m1 = new \MongoId($productRef);
        $product = $collection->findOne(array('_id'=>$m1));
        return $product;
    }
    
    private function getPolicy()
    {
        
        $policy = array();

        if ($this->policyId) {
            $policy['_id'] = $this->policyId;
        }

        $policy['quote_ref']    = $this->policyData['quote_ref'];
        $policy['start_date']   = $this->policyData['data']['start_date'];
        $policy['end_date']     = $this->policyData['data']['end_date'];
        $policy['abroad']       = isset($this->policyData['data']['abroad']) ? $this->policyData['data']['abroad'] : null;
        if ($this->policyData['data']['destination']) {
            $policy['destination']  = $this->policyData['data']['destination'];
        }
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
        
        if(!empty($this->product['wube'])){
            $policy['product']['wube']      = $this->product['wube'];
        }
        
        $policy['product']['elements'] = [];
        foreach ($this->product['elements'] as $elem) {
            $policy['product']['elements'][] = array(
                                                'kube'=>$elem['kube'],
                                                'su'=>$elem['value'],
                                                'currency'=>$elem['currency'],
                                                'division'=>$elem['division']
                                                );
        }
        $policy['product']['options'] = [];
        if (!empty($this->policyData['data']['option_values'])) {
            foreach ($this->policyData['data']['option_values'] as $option) {
                if ($option['value']==true) {
                    foreach ($this->product['options'] as $prodOpt) {
                        if ($prodOpt['code']==$option['code']) {
                            $policy['product']['options'][] = array(
                                                                'code'      =>$option['code'],
                                                                'tuecode'   =>$prodOpt['tucode']
                            );
                        }
                    }
                }

            }
        }
        $policy['DateTime'] = \DateTime::createFromFormat('U.u', microtime(true))->format("YmdHisu");
        return $policy;
    }

    public function save()
    {
        $policy = $this->getPolicy();

        $policyCollection = $this->mongoDB->selectCollection(CP_POLICIES);
        if ($policyCollection->insert($policy)) {
            $this->policyId = $policy["_id"];

            event(new IssuedPolicyEvent($this));


            return true;
        }

        return false;
    }
}

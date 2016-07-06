<?php

namespace App\apiModels\travel;

use App\Events\IssuedPolicyEvent;

class PolicyModel implements \JsonSerializable
{
    public $productRef;
    public $policyData;
    public $mongoDB;
    public $amount;
    public $tariff_amount;
    public $netto_amount;
    public $solicitors;
    public $partner;
    public $product;
    public $status;
    public $policyId = null;

    public function jsonSerialize()
    {
        return $this->getPolicy();
    }
    
    public function setPolicy($product_ref, $policyData, $partner, $status, $errors)
    {
        
        $this->productRef = $product_ref;
        $this->policyData = $policyData['request'];
        $this->amount = $policyData['amount'];
        $this->tariff_amount = $policyData['tariff_amount'];
        $this->netto_amount = $policyData['netto_amount'];
        $this->solicitors = $policyData['solicitors'];
        $this->product = $this->getProduct($this->productRef);
        $this->partner = $partner;
        $this->status = $status;
        $this->errors = $errors;
        $this->partnerData = $this->partner->getPartnerData();
        return $this->getPolicy();
    }
    
    public function getProduct($productRef)
    {
        return app('db')->collection(CP_TRAVEL_OFFERS_COL)->find($productRef);
    }
    
    private function getPolicy()
    {
        $policy = array();

        if ($this->policyId) {
            $policy['_id'] = $this->policyId;
        }

        $policy['quote_ref']    = $this->policyData['quote_ref'];
        $policy['policy_date']    = $this->policyData['policy_date'];
        $policy['policy_number']    = $this->policyData['policy_number'];
        $policy['start_date']   = $this->policyData['data']['start_date'];
        $policy['end_date']     = $this->policyData['data']['end_date'];
        $policy['abroad'] = isset($this->policyData['data']['abroad']) ? $this->policyData['data']['abroad'] : null;
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

        $policy['tariff_amount']   = $this->tariff_amount;
        $policy['netto_amount']   = $this->netto_amount;
        $policy['solicitors']   = $this->solicitors;
        
        $policy['partner']['code']          = $this->partnerData['code'];
        $policy['partner']['customerId']    = $this->partnerData['customerId'];
        $policy['partner']['travel_api']    = $this->partnerData['apis']['travel']['version'];
        
        $policy['product'] = $this->product['configuration'];

        if (array_key_exists('quotation', $this->product['configuration'])) {
            unset($this->product['configuration']['quotation']);
        }

        $policy['product']['code'] = $this->product['code'];
        $policy['product']['name'] = $this->product['name'];

        $policy['product']['elements'] = [];
        foreach ($this->product['elements'] as $elem) {
            $policy['product']['elements'][] = array(
                                                'kube'=>$elem['kube'],
                                                'su'=> floatval($elem['value']),
                                                'currency'=>$elem['currency'],
                                                'division'=>floatval($elem['division'])
                                                );
        }
        $policy['product']['options'] = [];
        if (array_key_exists('option_values', $this->product['configuration'])) {
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

        if ($this->policyId = app('db')->collection(CP_POLICIES)->insertGetId($policy)) {
            event(new IssuedPolicyEvent($this));
            return true;
        }

        return false;
    }
}

<?php

namespace Tue\Printing\Mappers;

use App\Policy;
use Carbon\Carbon;
use stdClass;
use Tue\Printing\Traits\ArraySetter;

class PolicyMapperPrint
{   
    use ArraySetter;

    public static function fromModels(array $policies)
    {
    	$policyPrintRequests = [];
        foreach ($policies as $policy) {
        	$policyPrintRequests[] = self::fromModel($policy);
        }
        return $policyPrintRequests;
    }

    public static function fromModel(Policy $policy, array $policyPrintRequest = [])
    {   

        $id = $policy->id;
        $promo_code = $policy->promo_code;
        $source = $policy->source;
        $product_id = $policy->product_id;
        $policy_date = $policy->policy_date;
        $policy_number = $policy->policy_number;
        $start_date = $policy->start_date;
        $end_date = $policy->end_date;
        $abroad = $policy->abroad;
        $destination = $policy->destination;

        self::set($policyPrintRequest, 'id', $id);
        self::set($policyPrintRequest, 'promo', $promo_code);
        self::set($policyPrintRequest, 'source', $source);
        self::set($policyPrintRequest, 'product_id', $product_id);
        self::set($policyPrintRequest, 'policy_date', $policy_date);
        self::set($policyPrintRequest, 'policy_number', $policy_number);
        self::set($policyPrintRequest, 'start_date', $start_date);
        self::set($policyPrintRequest, 'end_date', $end_date);
        self::set($policyPrintRequest, 'abroad', $abroad);
        self::set($policyPrintRequest, 'destination', $destination);
        
        // !isset($policy->addons) ?: $policyPrintRequest['addons'] = PolicyAddonsMapperPrint::addons($policy->addons);
        // !isset($policy->sum_insured) ?: $policyPrintRequest = array_merge($policyPrintRequest, PolicySumInsuredMapperPrint::sumInsured($policy->sum_insured, 'Sum_Insureds_'));
        // !isset($policy->policy_holder) ?: $policyPrintRequest = array_merge($policyPrintRequest, PolicyHolderMapperPrint::policyHolder($policy->policy_holder, 'policy_holder_'));
        !isset($policy->insureds) ?: $policyPrintRequest['insured'] =  PolicyInsuredMapperPrint::insureds($policy->insureds);
        // !isset($policy->configured_risks) ?: $policyPrintRequest['configured_risks'] = PolicyConfiguredRiskMapperPrint::configuredRisks($policy->configured_risks, 'configured_risks_');
        // !isset($policy->solicitors) ?: $policyPrintRequest = array_merge($policyPrintRequest, PolicySolicitorsMapperPrint::solicitors($policy->solicitors, 'solicitors'));
        // !isset($policy->premium) ?: $policyPrintRequest = array_merge($policyPrintRequest, PolicyPremiumMapperPrint::policyPremium($policy->premium, 'premium_'));
        // !isset($policy->tariff_premium) ?: $policyPrintRequest = array_merge($policyPrintRequest, PolicyPremiumMapperPrint::policyPremium($policy->tariff_premium, 'tariff_premium_'));
        // !isset($policy->netto_premium) ?: $policyPrintRequest = array_merge($policyPrintRequest, PolicyPremiumMapperPrint::policyPremium($policy->netto_premium, 'netto_premium_'));
        // !isset($policy->possession) ?: $policyPrintRequest = array_merge($policyPrintRequest, PolicyPossesionMapperPrint::possessions($policy->possession, 'possesion_'));
        // !isset($policy->product) ?: $policyPrintRequest = array_merge($policyPrintRequest, PolicyProductMapperPrint::policyProduct($policy->product, 'product_'));
        // !isset($policy->partner) ?: $policyPrintRequest = array_merge($policyPrintRequest, PolicyPartnerMapperPrint::policyParnter($policy->partner, 'partner_'));
        !isset($policy->options) ?: $policyPrintRequest['options'] =  PolicyOptionsMapperPrint::options($policy->options);
        
        return $policyPrintRequest;
    }
}
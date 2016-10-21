<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\PolicyIssueRequest;
use App\Policy;

class PolicyIssueRequestMapper
{
    public static function fromModels(array $policies)
    {
    	$policyIssueRequests = [];
        foreach ($policies as $policy) {
        	$policyIssueRequests[] = self::fromModel($policy);
        }
        return $policyIssueRequests;
    }

    public static function fromModel(Policy $policy, PolicyIssueRequest $policyIssueRequest = null)
    {   
        if (!$policyIssueRequest) {
            $policyIssueRequest = new PolicyIssueRequest();
        }
        
        !isset($policy->policy_date) ?: $policyIssueRequest->setPolicyDate($policy->policy_date);
        !isset($policy->policy_number) ?: $policyIssueRequest->setPolicyNumber($policy->policy_number);
        !isset($policy->start_date) ?: $policyIssueRequest->setStartDate($policy->start_date);
        !isset($policy->end_date) ?: $policyIssueRequest->setEndDate($policy->end_date);
        !isset($policy->abroad) ?: $policyIssueRequest->setAbroad($policy->abroad);
        !isset($policy->destination) ?: $policyIssueRequest->setDestination($policy->destination);
        $policyIssueRequest->setOptions([]);
        $policyIssueRequest->setAddons([]);
        !isset($policy->policy_holder) ?: $policyIssueRequest->setPolicyHolder($policy->policy_holder);
        !isset($policy->insured) ?: $policyIssueRequest->setInsured($policy->insured);
        !isset($policy->solicitors) ?: $policyIssueRequest->setSolicitors($policy->solicitors);
        !isset($policy->premium) ?: $policyIssueRequest->setPremium($policy->premium);
        !isset($policy->tariff_premium) ?: $policyIssueRequest->setTariffPremium($policy->tariff_premium);
        !isset($policy->netto_premium) ?: $policyIssueRequest->setNettoPremium($policy->netto_premium);
        !isset($policy->partner) ?: $policyIssueRequest->setPartner($policy->partner);
        !isset($policy->product) ?: $policyIssueRequest->setProduct($policy->product);

		return $policyIssueRequest;
    }
}

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
        
        $policyIssueRequest->setPolicyDate($policy->policy_date);
        $policyIssueRequest->setPolicyNumber($policy->policy_number);
        $policyIssueRequest->setStartDate($policy->start_date);
        $policyIssueRequest->setEndDate($policy->end_date);
        $policyIssueRequest->setAbroad($policy->abroad);
        $policyIssueRequest->setDestination($policy->destination);
        $policyIssueRequest->setOptions([]);
        $policyIssueRequest->setAddons([]);
        $policyIssueRequest->setPolicyHolder($policy->policy_holder);
        $policyIssueRequest->setInsured($policy->insured);
        $policyIssueRequest->setSolicitors($policy->solicitors);
        $policyIssueRequest->setPremium($policy->premium);
        $policyIssueRequest->setTariffPremium($policy->tariff_premium);
        $policyIssueRequest->setNettoPremium($policy->netto_premium);
        $policyIssueRequest->setPartner($policy->partner);
        $policyIssueRequest->setProduct($policy->product);

		return $policyIssueRequest;
    }
}

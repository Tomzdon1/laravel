<?php

namespace App\apiModels\travel\v1\mappers;

use App\apiModels\travel\v1\implementations;
use App\Policy;

class PolicyModelMapper
{

    public static function fromImportRequest(
        implementations\IMPORTREQUESTImpl $importPolicyRequest,
        Policy $policy = null
    ) {
        if (!$policy) {
            $policy = new Policy();
        }

        $policy->setSource('import');

        $policy->product_id = $importPolicyRequest->getProductRef();
        $policy->policy_date = $importPolicyRequest->getPolicyDate();
        $policy->policy_number = $importPolicyRequest->getPolicyNumber();
        $policy->start_date = $importPolicyRequest->getData()->getStartDate();
        $policy->end_date = $importPolicyRequest->getData()->getEndDate();
        $policy->abroad = $importPolicyRequest->getData()->getAbroad();
        $policy->destination = $importPolicyRequest->getData()->getDestination();
        $policy->options = $importPolicyRequest->getData()->getOptionValues();
        $policy->policy_holder = $importPolicyRequest->getPolicyHolder();
        $policy->insured = $importPolicyRequest->getInsured();
        $policy->solicitors = $importPolicyRequest->getSolicitors();
        $policy->premium = $importPolicyRequest->getAmount();
        $policy->tariff_premium = $importPolicyRequest->getTariffAmount();
        $policy->netto_premium = $importPolicyRequest->getNettoAmount();

        return $policy;
    }
}

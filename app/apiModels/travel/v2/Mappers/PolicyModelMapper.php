<?php

namespace App\apiModels\travel\v2\Mappers;

use App\apiModels\travel\v2\Implementations;
use App\Policy;

class PolicyModelMapper
{

    public static function fromImportPolicyRequest(
        Implementations\ImportPolicyRequestImpl $importPolicyRequest,
        Policy $policy = null
    ) {
        if (!$policy) {
            $policy = new Policy();
        }

        $policy->setSource('import');

        $policy->product_id = $importPolicyRequest->getProductId();
        $policy->policy_date = $importPolicyRequest->getPolicyDate();
        $policy->policy_number = $importPolicyRequest->getPolicyNumber();
        $policy->start_date = $importPolicyRequest->getData()->getStartDate();
        $policy->end_date = $importPolicyRequest->getData()->getEndDate();
        $policy->abroad = $importPolicyRequest->getData()->getAbroad();
        $policy->destination = $importPolicyRequest->getData()->getDestination();
        $policy->options = $importPolicyRequest->getData()->getOptions();
        $policy->addons = $importPolicyRequest->getData()->getAddons();
        $policy->sum_insured = $importPolicyRequest->getData()->getSumInsured();
        $policy->configured_risks = $importPolicyRequest->getData()->getConfiguredRisks();
        $policy->policy_holder = $importPolicyRequest->getPolicyHolder();
        $policy->insureds = $importPolicyRequest->getInsureds();
        $policy->solicitors = $importPolicyRequest->getSolicitors();
        $policy->possessions = $importPolicyRequest->getPossessions();
        $policy->premium = $importPolicyRequest->getPremium();
        $policy->tariff_premium = $importPolicyRequest->getTariffPremium();
        $policy->netto_premium = $importPolicyRequest->getNettoPremium();

        return $policy;
    }
}

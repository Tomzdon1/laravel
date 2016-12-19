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
        !isset($policy->policy_date) ? : $policyIssueRequest->setPolicyDate($policy->policy_date);
        !isset($policy->policy_number) ? : $policyIssueRequest->setPolicyNumber($policy->policy_number);
        !isset($policy->start_date) ? : $policyIssueRequest->setStartDate($policy->start_date);
        !isset($policy->end_date) ? : $policyIssueRequest->setEndDate($policy->end_date);
        !isset($policy->abroad) ? : $policyIssueRequest->setAbroad($policy->abroad);
        !isset($policy->destination) ? : $policyIssueRequest->setDestination($policy->destination);
        $policyIssueRequest->setOptions([]);
        $policyIssueRequest->setAddons([]);
        !isset($policy->policy_holder) ? : $policyIssueRequest->setPolicyHolder($policy->policy_holder);
        !isset($policy->insured) ? : $policyIssueRequest->setInsured($policy->insured);
        !isset($policy->solicitors) ? : $policyIssueRequest->setSolicitors($policy->solicitors);
        !isset($policy->premium) ? : $policyIssueRequest->setPremium($policy->premium);
        !isset($policy->tariff_premium) ? : $policyIssueRequest->setTariffPremium($policy->tariff_premium);
        !isset($policy->netto_premium) ? : $policyIssueRequest->setNettoPremium($policy->netto_premium);
        !isset($policy->partner) ? : $policyIssueRequest->setPartner($policy->partner);
        !isset($policy->product) ? : $policyIssueRequest->setProduct($policy->product);

        // Temporary fix
        // Block below to remove after merge with feature/internal-api-mapper
        if (is_array($policyIssueRequest->getPolicyDate())) {
            $policy_date = new \Carbon\Carbon($policyIssueRequest->getPolicyDate()['date'], new \DateTimeZone($policyIssueRequest->getPolicyDate()['timezone']));
            $policyIssueRequest->setPolicyDate($policy_date->toRfc3339String());
        }
        if (is_array($policyIssueRequest->getStartDate())) {
            $policy_date = new \Carbon\Carbon($policyIssueRequest->getStartDate()['date'], new \DateTimeZone($policyIssueRequest->getStartDate()['timezone']));
            $policyIssueRequest->setStartDate($policy_date->toRfc3339String());
        }
        if (is_array($policyIssueRequest->getEndDate())) {
            $policy_date = new \Carbon\Carbon($policyIssueRequest->getEndDate()['date'], new \DateTimeZone($policyIssueRequest->getEndDate()['timezone']));
            $policyIssueRequest->setEndDate($policy_date->toRfc3339String());
        }
        if (is_array($policyIssueRequest->getPolicyHolder()['data']['birth_date'])) {
            $policyHolder = $policyIssueRequest->getPolicyHolder();
            $birthDate = new \Carbon\Carbon($policyHolder['data']['birth_date']['date'], new \DateTimeZone($policyHolder['data']['birth_date']['timezone']));
            $policyHolder['data']['birth_date'] = $birthDate->toDateString();
            $policyIssueRequest->setPolicyHolder($policyHolder);
        }
        if (is_array($policyIssueRequest->getInsured())) {
            $insureds = $policyIssueRequest->getInsured();
            foreach ($insureds as &$insured) {
                if (is_array($insured['data']['birth_date'])) {
                    $birthDate = new \Carbon\Carbon($insured['data']['birth_date']['date'], new \DateTimeZone($insured['data']['birth_date']['timezone']));
                    $insured['data']['birth_date'] = $birthDate->toDateString();
                }
            }
            $policyIssueRequest->setInsured($insureds);
        }
        if (is_array($policyIssueRequest->getPremium()['date_rate'])) {
            $policyPremium = $policyIssueRequest->getPremium();
            $premium = new \Carbon\Carbon($policyPremium['date_rate']['date'], new \DateTimeZone($policyPremium['date_rate']['timezone']));
            $policyPremium['date_rate'] = $premium->toRfc3339String();
            $policyIssueRequest->setPremium($policyPremium);
        }
        if (is_array($policyIssueRequest->getTariffPremium()['date_rate'])) {
            $policyTariffPremium = $policyIssueRequest->getTariffPremium();
            $tariffPremium = new \Carbon\Carbon($policyTariffPremium['date_rate']['date'], new \DateTimeZone($policyTariffPremium['date_rate']['timezone']));
            $policyTariffPremium['date_rate'] = $tariffPremium->toRfc3339String();
            $policyIssueRequest->setTariffPremium($policyTariffPremium);
        }
        if (is_array($policyIssueRequest->getNettoPremium()['date_rate'])) {
            $policyNettoPremium = $policyIssueRequest->getNettoPremium();
            $nettoPremium = new \Carbon\Carbon($policyNettoPremium['date_rate']['date'], new \DateTimeZone($policyNettoPremium['date_rate']['timezone']));
            $policyNettoPremium['date_rate'] = $nettoPremium->toRfc3339String();
            $policyIssueRequest->setNettoPremium($policyNettoPremium);
        }
        // Temporary fix 
        // Block above to remove after merge with feature/internal-api-mapper

        return $policyIssueRequest;
    }
}

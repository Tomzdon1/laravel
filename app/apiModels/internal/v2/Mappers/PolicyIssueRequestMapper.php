<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\PolicyIssueRequest;
use App\Policy;
use Carbon\Carbon;

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

        !isset($policy->policy_date) ?: $policyIssueRequest->setPolicyDate(Carbon::instance($policy->policy_date->toDateTime())->toRfc3339String());
        !isset($policy->policy_number) ?: $policyIssueRequest->setPolicyNumber(strval($policy->policy_number));
        !isset($policy->start_date) ?: $policyIssueRequest->setStartDate(Carbon::instance($policy->start_date->toDateTime())->toRfc3339String());
        !isset($policy->end_date) ?: $policyIssueRequest->setEndDate(Carbon::instance($policy->end_date->toDateTime())->toRfc3339String());
        !isset($policy->abroad) ?: $policyIssueRequest->setAbroad(boolval($policy->abroad));
        !isset($policy->destination) ?: $policyIssueRequest->setDestination(strval($policy->destination));
        !isset($policy->options) ?: $policyIssueRequest->setOptions(OptionValueMapper::fromObjects($policy->options));
        !isset($policy->addons) ?: $policyIssueRequest->setAddons(OptionValueMapper::fromObjects($policy->addons));
        !isset($policy->policy_holder) ?: $policyIssueRequest->setPolicyHolder(PolicyHolderMapper::fromObject($policy->policy_holder));
        !isset($policy->insureds) ?: $policyIssueRequest->setInsureds(InsuredMapper::fromObjects($policy->insureds));
        !isset($policy->solicitors) ?: $policyIssueRequest->setSolicitors(SolicitorMapper::fromObjects($policy->solicitors));
        !isset($policy->premium) ?: $policyIssueRequest->setPremium(PremiumMapper::fromObject($policy->premium));
        !isset($policy->tariff_premium) ?: $policyIssueRequest->setTariffPremium(PremiumMapper::fromObject($policy->tariff_premium));
        !isset($policy->netto_premium) ?: $policyIssueRequest->setNettoPremium(PremiumMapper::fromObject($policy->netto_premium));
        !isset($policy->partner) ?: $policyIssueRequest->setPartner(PartnerMapper::fromObject($policy->partner));
        !isset($policy->product) ?: $policyIssueRequest->setOfferDefinition(OfferDefinitionMapper::fromObject($policy->product));

        return $policyIssueRequest;
    }
}
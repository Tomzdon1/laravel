<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\PolicyHolder;

class PolicyHolderMapper
{
    public static function fromObjects(array $policyHolders)
    {
    	$mappedPolicyHolders = [];
        foreach ($policyHolders as $policyHolder) {
        	$mappedPolicyHolders[] = self::fromObject($policyHolder);
        }
        return $mappedPolicyHolders;
    }

    public static function fromObject($policyHolder, PolicyHolder $mappedPolicyHolder = null)
    {   
        if (!$mappedPolicyHolder) {
            $mappedPolicyHolder = new PolicyHolder();
        }
        
        !isset($policyHolder->data) ?: $mappedPolicyHolder->setData(PersonDataMapper::fromObject($policyHolder->data));
        !isset($policyHolder->address) ?: $mappedPolicyHolder->setAddress(AddressMapper::fromObject($policyHolder->address));
        !isset($policyHolder->email) ?: $mappedPolicyHolder->setEmail(strval($policyHolder->email));
        !isset($policyHolder->telephone) ?: $mappedPolicyHolder->setTelephone(strval($policyHolder->telephone));
        !isset($policyHolder->agreements) ?: $mappedPolicyHolder->setAgreements(AgreementMapper::fromObjects($policyHolder->agreements));
        !isset($policyHolder->options) ?: $mappedPolicyHolder->setOptions(OptionValueMapper::fromObjects($policyHolder->options));
        !isset($policyHolder->addons) ?: $mappedPolicyHolder->setAddons(OptionValueMapper::fromObjects($policyHolder->addons));

		return $mappedPolicyHolder;
    }
}

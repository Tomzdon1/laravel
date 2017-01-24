<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\Insured;

class InsuredMapper
{
    public static function fromObjects(array $insureds)
    {
    	$mappedInsureds = [];
        foreach ($insureds as $insured) {
        	$mappedInsureds[] = self::fromObject($insured);
        }
        return $mappedInsureds;
    }

    public static function fromObject($insured, Insured $mappedInsured = null)
    {   
        if (!$mappedInsured) {
            $mappedInsured = new Insured();
        }
        
        !isset($insured->data) ?: $mappedInsured->setData(PersonDataMapper::fromObject($insured->data));
        !isset($insured->address) ?: $mappedInsured->setAddress(AddressMapper::fromObject($insured->address));
        !isset($insured->options) ?: $mappedInsured->setOptions(OptionValueMapper::fromObjects($insured->options));
        !isset($insured->addons) ?: $mappedInsured->setAddons(OptionValueMapper::fromObjects($insured->addons));

		return $mappedInsured;
    }
}

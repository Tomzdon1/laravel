<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\OptionValue;

class OptionValueMapper
{
    public static function fromObjects(array $optionValues)
    {
    	$mappedOptionValues = [];
        foreach ($optionValues as $optionValue) {
        	$mappedOptionValues[] = self::fromObject($optionValue);
        }
        return $mappedOptionValues;
    }

    public static function fromObject($optionValue, OptionValue $mappedOptionValue = null)
    {   
        if (!$mappedOptionValue) {
            $mappedOptionValue = new OptionValue();
        }
        
        !isset($optionValue->code) ?: $mappedOptionValue->setCode(strval($optionValue->code));
        !isset($optionValue->value) ?: $mappedOptionValue->setValue(strval($optionValue->value));
        !isset($optionValue->sub_options) ?: $mappedOptionValue->setSubOptions(OptionValueMapper::fromObjects($optionValue->sub_options));

		return $mappedOptionValue;
    }
}

<?php

namespace App\apiModels\travel\v2\Mappers;

use App\apiModels\travel\v2\Implementations\OptionDefinitionImpl;

class OptionDefinitionMapper
{
    public static function fromModels(array $options)
    {
    	$optionDefinitions = [];
        foreach ($options as $option) {
        	$optionDefinitions[] = self::fromModel($option);
        }
        return $optionDefinitions;
    }

    public static function fromModel(array $option)
    {
		$optionDefinition = new OptionDefinitionImpl();
		!array_key_exists('name', $option) ?: $optionDefinition->setName($option['name']);
		!array_key_exists('description', $option) ?: $optionDefinition->setDescription($option['description']);
		!array_key_exists('code', $option) ?: $optionDefinition->setCode($option['code']);
		!array_key_exists('value_type', $option) ?: $optionDefinition->setValueType($option['value_type']);
		!array_key_exists('changeable', $option) ?: $optionDefinition->setChangeable($option['changeable']);
		!array_key_exists('scope', $option) ?: $optionDefinition->setScope($option['scope']);
		!array_key_exists('sub_options', $option) ? $optionDefinition->setSubOptions([]) : $optionDefinition->setSubOptions($option['sub_options']);
		return $optionDefinition;
    }
}

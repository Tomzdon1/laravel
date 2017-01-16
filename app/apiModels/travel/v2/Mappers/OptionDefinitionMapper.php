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

    public static function fromModel($option)
    {
        $optionDefinition = new OptionDefinitionImpl();
        !isset($option->name) ? : $optionDefinition->setName($option->name);
        !isset($option->description) ? : $optionDefinition->setDescription($option->description);
        !isset($option->code) ? : $optionDefinition->setCode($option->code);
        !isset($option->value_type) ? : $optionDefinition->setValueType($option->value_type);
        try {
            !isset($option->scope) ? : $optionDefinition->setScope($option->scope);
        } catch (\InvalidArgumentException $e) {
            !isset($option->scope) ? : $optionDefinition->setScope(ucfirst(camel_case(strtolower($option->scope))));
        }
        !isset($option->sub_options)
            ? $optionDefinition->setSubOptions([])
            : $optionDefinition->setSubOptions($option->sub_options);
        return $optionDefinition;
    }
}

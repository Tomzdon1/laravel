<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;

class PolicyOptionsMapperPrint
{

    use ArraySetter;

    public static function options(array $options, $prefix = '')
    {
    	$flattenOptions = [];
        foreach ($options as $option) {
        	$flattenOptions[] = array_merge(self::option($option, $prefix), $flattenOptions);
        }
        return $flattenOptions;
    }

    public static function option($option, $prefix = '' )
    {   
        $flattenOption = [];
        
        self::set($flattenOption, 'value', $option->value);
        self::set($flattenOption, 'code', $option->code);
        
		return $flattenOption;
    }
}

<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;

class PolicyPossesionMapperPrint
{

    use ArraySetter;

    public static function possessions(array $possessions, $prefix = '')
    {
    	$flattenPossessions = [];
        foreach ($possessions as $key=>$possession) {
        	$flattenPossessions[$key] =self::possession($possession, $prefix);
        }
        return $flattenPossessions;
    }

    public static function possession($possession, $prefix = '' )
    {   
        $flattenPossession = [];
        
        self::set($flattenPossession, $prefix.'name', $possession->name);
        self::set($flattenPossession, $prefix.'id', $possession->id);
        self::set($flattenPossession, $prefix.'value', $possession->value);
        self::set($flattenPossession, $prefix.'type', $possession->type);
        self::set($flattenPossession, $prefix.'attributes', $possession->attributes);
        
		return $flattenPossession;
    }
}

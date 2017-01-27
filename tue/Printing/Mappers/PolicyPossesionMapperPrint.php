<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;

class PolicyPossesionMapperPrint
{

    use ArraySetter;

    public static function possessions(array $possessions, $prefix = '')
    {
    	$flattenPossessions = [];
        foreach ($possessions as $possession) {
        	$flattenPossessions[] = array_merge(self::possession($possession, $prefix), $flattenPossessions);
        }
        return $flattenPossessions;
    }

    public static function possession($possession, $prefix = '' )
    {   
        $flattenPossession = [];
        
        self::set($flattenPossession, 'name', $possession->name);
        self::set($flattenPossession, 'id', $possession->id);
        self::set($flattenPossession, 'value', $possession->value);
        self::set($flattenPossession, 'type', $possession->type);
        self::set($flattenPossession, 'attributes', $possession->attributes);
        
		return $flattenPossession;
    }
}

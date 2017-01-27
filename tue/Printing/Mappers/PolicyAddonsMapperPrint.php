<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;

class PolicyAddonsMapperPrint
{

    use ArraySetter;

    public static function addons(array $addons, $prefix = '')
    {
    	$flattenAddons = [];
        foreach ($addons as $addon) {
        	$flattenAddons[] = array_merge(self::addon($addon, $prefix), $flattenAddons);
        }
        return $flattenAddons;
    }

    public static function addon($addon, $prefix = '' )
    {   
        $flattenAddon = [];
        
        self::set($flattenAddon, 'value', $addon->value);
        self::set($flattenAddon, 'code', $addon->code);
        
		return $flattenAddon;
    }
}
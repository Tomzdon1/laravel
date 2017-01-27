<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;

class PolicySolicitorsMapperPrint
{

    use ArraySetter;

    public static function solicitors(array $solicitors, $prefix = '')
    {
    	$flattenSolicitors = [];
        foreach ($solicitors as $solicitor) {
        	$flattenSolicitors[] = array_merge(self::solicitor($solicitor, $prefix), $flattenSolicitors);
        }
        return $flattenSolicitors;
    }

    public static function solicitor($addon, $prefix = '' )
    {   
        $flattenSolicitor= [];
        
        self::set($flattenSolicitor, 'solicitor_id', $solicitor->solicitor_id);
        self::set($flattenSolicitor, 'agent_id', $solicitor->agent_id);
        
		return $flattenSolicitor;
    }
}


<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;

class PolicyAgreementsMapperPrint
{

    use ArraySetter;

    public static function agreements(array $agreements, $prefix = '')
    {
    	$flattenAgreements = [];
        foreach ($agreements as $key=>$agreement) {
        	$flattenAgreements[$key] = self::agreement($agreement, $key, $prefix);
        }
        return $flattenAgreements;
    }

    public static function agreement($agreement, $key, $prefix = '' )
    {   
        $flattenAgreement =[];
        
        self::set($flattenAgreement,  $prefix.'description', $agreement->description);
        self::set($flattenAgreement,  $prefix.'value', $agreement->value);
        self::set($flattenAgreement,  $prefix.'code', $agreement->code);

		return $flattenAgreement;
    }
}

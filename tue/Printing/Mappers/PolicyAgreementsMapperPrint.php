<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;

class PolicyAgreementsMapperPrint
{

    use ArraySetter;

    public static function agreements(array $agreements, $prefix = '')
    {
    	$flattenAgreements = [];
        foreach ($agreements as $agreement) {
        	$flattenAgreements[] = array_merge(self::agreement($agreement, $prefix), $flattenAgreements);
        }
        return $flattenAgreements;
    }

    public static function agreement($agreement, $prefix = '' )
    {   
        $flattenAgreement = [];
        
        self::set($flattenAgreement, 'description', $agreement->description);
        self::set($flattenAgreement, 'value', $agreement->value);
        self::set($flattenAgreement, 'code', $agreement->code);

		return $flattenAgreement;
    }
}

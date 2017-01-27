<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;
use stdClass;

class PolicyPartnerMapperPrint
{

    use ArraySetter;

    public static function policyParnter(stdClass $policyParnter, $prefix = '')
    {
        $flattenPolicyParnter = [];
        
        self::set($flattenPolicyParnter, $prefix . 'name', $policyParnter->name);
        self::set($flattenPolicyParnter, $prefix . 'code', $policyParnter->code);

        return $flattenPolicyParnter;
    }
}

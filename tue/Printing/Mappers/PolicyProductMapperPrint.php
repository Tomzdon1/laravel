<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;
use stdClass;

class PolicyProductMapperPrint
{

    use ArraySetter;

    public static function policyProduct(stdClass $policyProduct, $prefix = '')
    {
        $flattenPolicyProduct = [];
        
        self::set($flattenPolicyProduct, $prefix . 'name', $policyProduct->name);
        self::set($flattenPolicyProduct, $prefix . 'code', $policyProduct->code);

        return $flattenPolicyProduct;
    }
}

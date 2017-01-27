<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;
use stdClass;

class PolicyAddressMapperPrint
{

    use ArraySetter;

    public static function policyAddress(stdClass $policyAddress, $prefix = '')
    {
        $flattenPolicyAddress = [];

        self::set($flattenPolicyAddress, $prefix . 'country', $policyAddress->country);
        self::set($flattenPolicyAddress, $prefix . 'post_code', $policyAddress->post_code);
        self::set($flattenPolicyAddress, $prefix . 'city', $policyAddress->city);
        self::set($flattenPolicyAddress, $prefix . 'street', $policyAddress->street);
        self::set($flattenPolicyAddress, $prefix . 'house_no', $policyAddress->house_no);
        self::set($flattenPolicyAddress, $prefix . 'flat_no', $policyAddress->flat_no);

        return $flattenPolicyAddress;
    }
}

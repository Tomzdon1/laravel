<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;
use stdClass;

class PolicyPremiumMapperPrint
{

    use ArraySetter;

    public static function policyPremium(stdClass $policyPremium, $prefix = '')
    {
        $flattenPolicyPremium = [];

        
        self::set($flattenPolicyPremium, $prefix . 'value_base', $policyPremium->value_base);
        self::set($flattenPolicyPremium, $prefix . 'value_base_currency', $policyPremium->value_base_currency);
        self::set($flattenPolicyPremium, $prefix . 'value', $policyPremium->value);
        self::set($flattenPolicyPremium, $prefix . 'value_currency', $policyPremium->value_currency);
        self::set($flattenPolicyPremium, $prefix . 'currency_date', $policyPremium->currency_date);
        self::set($flattenPolicyPremium, $prefix . 'date_rate', $policyPremium->date_rate);
       

        return $flattenPolicyPremium;
    }
}

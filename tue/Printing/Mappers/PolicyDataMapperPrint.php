<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;
use stdClass;

class PolicyDataMapperPrint
{

    use ArraySetter;

    public static function policyData(stdClass $policyData, $prefix = '')
    {
        $flattenPolicyData = [];

        self::set($flattenPolicyData, $prefix . 'first_name', $policyData->first_name);
        self::set($flattenPolicyData, $prefix . 'last_name', $policyData->last_name);
        self::set($flattenPolicyData, $prefix . 'birth_date', $policyData->birth_date);
        self::set($flattenPolicyData, $prefix . 'pesel', $policyData->pesel);
        self::set($flattenPolicyData, $prefix . 'nationality', $policyData->nationality);
        self::set($flattenPolicyData, $prefix . 'document_no', $policyData->document_no);
        self::set($flattenPolicyData, $prefix . 'bussiness_name', $policyData->bussiness_name);
        self::set($flattenPolicyData, $prefix . 'short_bussiness_name', $policyData->short_bussiness_name);
        self::set($flattenPolicyData, $prefix . 'nip', $policyData->nip);
        self::set($flattenPolicyData, $prefix . 'type', $policyData->type);

        return $flattenPolicyData;
    }
}

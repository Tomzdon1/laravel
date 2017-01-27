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

        self::set($flattenPolicyParnter, $prefix . 'code', $policyParnter->code);
        self::set($flattenPolicyParnter, $prefix . 'name', $policyParnter->name);

        if (isset($policyParnter->code)) {
            $crmConnector = app()->make('CRMConnector');
            $crmPartnerData = $crmConnector->getPartnerData('00700184');
            self::set($flattenPolicyParnter, $prefix . 'full_name', $crmPartnerData->name);
            self::set($flattenPolicyParnter, $prefix . 'description', $crmPartnerData->description);
            self::set($flattenPolicyParnter, $prefix . 'nip', $crmPartnerData->nip);
            self::set($flattenPolicyParnter, $prefix . 'street', $crmPartnerData->ulica_siedziba);
            self::set($flattenPolicyParnter, $prefix . 'house_no', $crmPartnerData->nr_budynku_siedziba);
            self::set($flattenPolicyParnter, $prefix . 'flat_no', $crmPartnerData->nr_lokalu_siedziba);
            self::set($flattenPolicyParnter, $prefix . 'post_code', $crmPartnerData->kod_siedziba);
            self::set($flattenPolicyParnter, $prefix . 'city', $crmPartnerData->miejscowosc_siedziba);
            self::set($flattenPolicyParnter, $prefix . 'country', $crmPartnerData->kraj_siedziba);
        }

        return $flattenPolicyParnter;
    }
}

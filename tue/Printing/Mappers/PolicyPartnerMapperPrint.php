<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;
use stdClass;
use Tue\PartnerData\PartnerData;

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

            $fullName = $crmPartnerData->getName();
            $description = $crmPartnerData->getDescription();
            $nip = $crmPartnerData->getNip();
            $ulica_siedziba = $crmPartnerData->getStreet();
            $nr_budynku_siedziba = $crmPartnerData->getHouseNo();
            $nr_lokalu_siedziba = $crmPartnerData->getFlatNo();
            $kod_siedziba = $crmPartnerData->getPostCode();
            $miejscowosc_siedziba = $crmPartnerData->getCity();
            $kraj_siedziba = $crmPartnerData->getCountry();
            
            self::set($flattenPolicyParnter, $prefix . 'full_name', $fullName);
            self::set($flattenPolicyParnter, $prefix . 'description', $description);
            self::set($flattenPolicyParnter, $prefix . 'nip', $nip);
            self::set($flattenPolicyParnter, $prefix . 'street', $ulica_siedziba);
            self::set($flattenPolicyParnter, $prefix . 'house_no', $nr_budynku_siedziba);
            self::set($flattenPolicyParnter, $prefix . 'flat_no', $nr_lokalu_siedziba);
            self::set($flattenPolicyParnter, $prefix . 'post_code', $kod_siedziba);
            self::set($flattenPolicyParnter, $prefix . 'city', $miejscowosc_siedziba);
            self::set($flattenPolicyParnter, $prefix . 'country', $kraj_siedziba);
        }

        return $flattenPolicyParnter;
    }
}

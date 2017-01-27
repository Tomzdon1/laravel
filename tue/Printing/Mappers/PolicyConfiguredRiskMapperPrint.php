<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;

class PolicyConfiguredRiskMapperPrint
{

    use ArraySetter;

    public static function configuredRisks(array $configuredRisks, $prefix = '')
    {
    	$flattenConfiguredRisks = [];
        foreach ($configuredRisks as $configuredRisk) {
        	$flattenConfiguredRisks[] = array_merge(self::configuredRisk($configuredRisk, $prefix), $flattenConfiguredRisks);
        }
        return $flattenConfiguredRisks;
    }

    public static function configuredRisk($configuredRisk, $prefix = '' )
    {   
        $flattenConfiguredRisk = [];
        
        self::set($flattenConfiguredRisk, 'code', $configuredRisk->code);
        self::set($flattenConfiguredRisk, 'sum_insured', $configuredRisk->sum_insured);
        self::set($flattenConfiguredRisk, 'start_date', $configuredRisk->start_date);
        self::set($flattenConfiguredRisk, 'end_date', $configuredRisk->end_date);
        self::set($flattenConfiguredRisk, 'end_date', $configuredRisk->end_date);
        !isset($configuredRisk->possession) ?: $flattenConfiguredRisk = array_merge($policyPrinflattenConfiguredRisktRequest, PolicyPossesionMapperPrint::possessions($configuredRisk->possession));
        
		return $flattenConfiguredRisk;
    }
}

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
        	$flattenConfiguredRisks[] = self::configuredRisk($configuredRisk, $prefix);
        }
        return $flattenConfiguredRisks;
    }

    public static function configuredRisk($configuredRisk, $prefix = '' )
    {   
        $flattenConfiguredRisk = [];
        
        self::set($flattenConfiguredRisk, $prefix.'code', $configuredRisk->code);
        self::set($flattenConfiguredRisk, $prefix.'sum_insured', $configuredRisk->sum_insured);
        self::set($flattenConfiguredRisk, $prefix.'start_date', $configuredRisk->start_date);
        self::set($flattenConfiguredRisk, $prefix.'end_date', $configuredRisk->end_date);
        self::set($flattenConfiguredRisk, $prefix.'end_date', $configuredRisk->end_date);
        !isset($configuredRisk->possessions) ?: $flattenConfiguredRisk['possession'] = PolicyPossesionMapperPrint::possessions($configuredRisk->possessions, 'possession_');
        
		return $flattenConfiguredRisk;
    }
}

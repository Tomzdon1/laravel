<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\Risk;

class RiskMapper
{
    public static function fromObjects(array $risks)
    {
    	$mappedRisks = [];
        foreach ($risks as $risk) {
        	$mappedRisks[] = self::fromObject($risk);
        }
        return $mappedRisks;
    }

    public static function fromObject($risk, Risk $mappedRisk = null)
    {   
        if (!$mappedRisk) {
            $mappedRisk = new Risk();
        }
        
        !isset($risk->kube) ?: $mappedRisk->setCode(strval($risk->kube));
        !isset($risk->kubeName) ?: $mappedRisk->setName(strval($risk->kubeName));
        !isset($risk->cmp) ?: $mappedRisk->setCompany(strval($risk->cmp));
        !isset($risk->value) ?: $mappedRisk->setSumInsured(floatval($risk->value));
        !isset($risk->currency) ?: $mappedRisk->setCurrency(strval($risk->currency));
        !isset($risk->division) ?: $mappedRisk->setDivision(floatval($risk->division));

		return $mappedRisk;
    }
}

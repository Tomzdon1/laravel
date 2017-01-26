<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\Premium;
use Carbon\Carbon;

class PremiumMapper
{
    public static function fromObjects(array $premiums)
    {
    	$mappedPremiums = [];
        foreach ($premiums as $premium) {
        	$mappedPremiums[] = self::fromObject($premium);
        }
        return $mappedPremiums;
    }

    public static function fromObject($premium, Premium $mappedPremium = null)
    {   
        if (!$mappedPremium) {
            $mappedPremium = new Premium();
        }

        !isset($premium->value_base) ?: $mappedPremium->setValueBase(floatval($premium->value_base));
        !isset($premium->value_base_currency) ?: $mappedPremium->setValueBaseCurrency(strval($premium->value_base_currency));
        !isset($premium->value) ?: $mappedPremium->setValue(floatval($premium->value));
        !isset($premium->value_currency) ?: $mappedPremium->setValueCurrency(strval($premium->value_currency));
        !isset($premium->currency_rate) ?: $mappedPremium->setCurrencyRate(floatval($premium->currency_rate));
        !isset($premium->date_rate) ?: $mappedPremium->setDateRate(Carbon::instance($premium->date_rate->toDateTime())->toRfc3339String());

        return $mappedPremium;
    }
}

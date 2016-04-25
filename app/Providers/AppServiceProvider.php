<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    	app('validator')->extend('afterEqual', function($attribute, $value, $parameters) {
            $date = $parameters[0];
            return strtotime($value) >= strtotime($date);
        });

        app('validator')->replacer('afterEqual', function($message, $attribute, $rule, $parameters) {
	        return str_replace(':date', $parameters[0], $message);
	    });

        app('validator')->extend('countryCode', function($attribute, $value, $parameters) {
        	return (new \Monarobase\CountryList\CountryList())->has($value);
        });

        app('validator')->extend('destinationCode', function($attribute, $value, $parameters) {
        	return (new \Monarobase\CountryList\CountryList())->has($value) || in_array($value, ['EU', 'WR']);
        });

		app('validator')->extend('currencyCode', function($attribute, $value, $parameters) {
        	try {
        		(new \Alcohol\ISO4217())->getByAlpha3($value);
        		return true;
        	}
        	catch (\Exception $e) {
        		return false;
        	}
        });

        app('validator')->extend('pesel', function($attribute, $value, $parameters) {
        	if (!preg_match('/^[0-9]{11}$/', $value)) {
				return false;
			}
		 
			$arrSteps = array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3, 1);
			$intSum = 0;

			for ($i = 0; $i < 11; $i++)
			{
				$intSum += $arrSteps[$i] * $value[$i];
			}

			return $intSum % 10 === 0;
        });

        /**
        *   Validate currency conversion.
        *
        *   $parameters[0] value_base
        *   $parameters[1] currency_rate
        *   $parameters[2] precision
        */
        app('validator')->extend('value_conversion', function($attribute, $value, $parameters, $validator) {
            $value_base = array_get($validator->getData(), $parameters[0], null);
            $currency_rate = array_get($validator->getData(), $parameters[1], null);
            $precision = $parameters[2];

            return $value == round($value_base * $currency_rate, $precision);
        });

        /**
        *   Validate promotional amount.
        *
        *   $parameters[0] promo_code
        *   $parameters[1] tariff_amount (value_base)
        *   $parameters[2] precision
        */
        app('validator')->extend('promotional_amount', function($attribute, $value, $parameters, $validator) {
            $promo_code = array_get($validator->getData(), $parameters[0], null);
            $tariff_value_base = array_get($validator->getData(), $parameters[1], null);
            $precision = $parameters[2];

            return $value == round($tariff_value_base * (1 - $promo_code/100), $precision);
        });

        /**
        *   Validate amount.
        * 
        *   $parameters[0] amount type (e.g. netto_amount)
        */
        app('validator')->extend('amount_value', function($attribute, $value, $parameters, $validator) {
            $amountType =  strstr($attribute, '.', true);
            $amountTypeGetter = camel_case('get' . $amountType);

            foreach (json_decode(app('request')->getContent(), true) as $policy) {
                // $cursor = app('db')->selectCollection(CP_TRAVEL_OFFERS_COL)->find(['_id' => $validator->getData()['product_ref']]);
                $dbOffer = app('db')->collection(CP_TRAVEL_OFFERS_COL)->find($validator->getData()['product_ref']);
                
                if ($dbOffer) {
                    $serializer = new \App\apiModels\ObjectSerializer();
                    $importPolicy = $serializer->deserialize($policy, '\App\apiModels\travel\v1\prototypes\IMPORTREQUEST', null, false);
                    $importPolicy->setVarCode($dbOffer['code']);

                    if ($dbOffer['configuration']['quotation']['type'] == 'formula') {
                        $importPolicy->calculateAmount($dbOffer['configuration']);
                    } elseif ($dbOffer['configuration']['quotation']['type'] == 'excel') {
                        $excelPath = env('EXCEL_DIRECTORY') . '/' . $dbOffer['configuration']['quotation']['file'];

                        if ($excelPath) {
                            $excelFile = new \Tue\Calculating\calculateTravelExcel($excelPath);
                        }

                        if ($excelFile) {
                            $valueBaseImport = $importPolicy->{$amountTypeGetter}()->getValueBase();
                            $importPolicy->calculateExcelAmount($dbOffer['configuration'], $excelFile);
                            if ($valueBaseImport != $importPolicy->{$amountTypeGetter}()->getValueBase()) {
                                app('log')->debug("Validator amount_value fails! Received: $valueBaseImport, should be: " . $importPolicy->{$amountTypeGetter}()->getValueBase());
                                return false;
                            }
                        }
                    }
                }
            }

            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

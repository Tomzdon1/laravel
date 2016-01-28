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
    	\Validator::extend('afterEqual', function($attribute, $value, $parameters) {
            $date = $parameters[0];
            return strtotime($value) >= strtotime($date);
        });

        \Validator::replacer('afterEqual', function($message, $attribute, $rule, $parameters) {
	        return str_replace(':date', $parameters[0], $message);
	    });

        \Validator::extend('countryCode', function($attribute, $value, $parameters) {
        	return (new \Monarobase\CountryList\CountryList())->has($value);
        });

        \Validator::extend('destinationCode', function($attribute, $value, $parameters) {
        	return (new \Monarobase\CountryList\CountryList())->has($value) || in_array($value, ['EU', 'WR']);
        });

		\Validator::extend('currencyCode', function($attribute, $value, $parameters) {
        	try {
        		(new \Alcohol\ISO4217())->getByAlpha3($value);
        		return true;
        	}
        	catch (\Exception $e) {
        		return false;
        	}
        });

        \Validator::extend('pesel', function($attribute, $value, $parameters) {
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
        \Validator::extend('value_conversion', function($attribute, $value, $parameters, $validator) {
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
        \Validator::extend('promotional_amount', function($attribute, $value, $parameters, $validator) {
            $promo_code = array_get($validator->getData(), $parameters[0], null);
            $tariff_value_base = array_get($validator->getData(), $parameters[1], null);
            $precision = $parameters[2];

            return $value == round($tariff_value_base * (1 - $promo_code/100), $precision);
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

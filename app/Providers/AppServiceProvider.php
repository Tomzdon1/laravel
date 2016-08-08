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
    	app('validator')->extend('afterEqual', function($attribute, $value, $parameters, $validator) {
            $date = $parameters[0];
            
            if (!strtotime($date)) {
                $date = array_get($validator->getData(), $parameters[0], null);
            }

            return strtotime($value) >= strtotime($date);
        });

        app('validator')->replacer('afterEqual', function($message, $attribute, $rule, $parameters) {
	        return str_replace(':date', $parameters[0], $message);
	    });

        app('validator')->extend('beforeEqual', function($attribute, $value, $parameters, $validator) {
            $date = $parameters[0];
            
            if (!strtotime($date)) {
                $date = array_get($validator->getData(), $parameters[0], null);
            }
            
            return strtotime($value) <= strtotime($date);
        });

        app('validator')->replacer('beforeEqual', function($message, $attribute, $rule, $parameters) {
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
        app('validator')->extend('valueConversion', function($attribute, $value, $parameters, $validator) {
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
        app('validator')->extend('promotionalAmount', function($attribute, $value, $parameters, $validator) {
            $promo_code = array_get($validator->getData(), $parameters[0], null);
            $tariff_value_base = array_get($validator->getData(), $parameters[1], null);
            $precision = $parameters[2];

            return $value == round($tariff_value_base * (1 - $promo_code/100), $precision);
        });

        /**
        *   Validate amount.
        * 
        */
        app('validator')->extend('amountValue', function($attribute, $value, $parameters, $validator) {
            $valid = true;
            $amountType =  strstr($attribute, '.', true);

            $calculatedAmounts = $validator->getCustomAttributes()['calculatedAmounts'];
            $valueBaseCalculated = $calculatedAmounts[$amountType]->getValueBase();
            
            if ($value != $valueBaseCalculated) {
                $validator->addReplacer('amountValue', function ($message, $attribute, $rule, $parameters) use ($value, $valueBaseCalculated) {
                    return str_replace(':calculation', $valueBaseCalculated, str_replace(':value', $value, $message));
                });

                if (env('APP_DEBUG', false)) {
                    app('log')->debug("Validator amount_value fails! Received: $value, should be: " . $valueBaseCalculated);
                }

                $valid = false;
            }
            
            return $valid;
        });

        /**
        *   Check that calculation is correct.
        * 
        */
        app('validator')->extend('correctCalculation', function($attribute, $value, $parameters, $validator) {
            $valid = true;
            $amountType =  strstr($attribute, '.', true);

            $calculatedAmounts = $validator->getCustomAttributes()['calculatedAmounts'];
            $valueBaseCalculated = $calculatedAmounts[$amountType]->getValueBase();
            
            if ($valueBaseCalculated < 0) {
                if (env('APP_DEBUG', false)) {
                    app('log')->debug("Data used for the calculation are incompatible with GCI.");
                }
                
                $valid = false;
            }
            
            return $valid;
        });

        /**
        *   Validate product reference.
        *
        */
        app('validator')->extend('productRef', function($attribute, $value, $parameters, $validator) {
            return !empty(app('db')->collection('travel_offers')->find($value));
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

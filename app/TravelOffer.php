<?php

namespace App;

class TravelOffer extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Validators of model atributes
     *
     * @var array
     */
    public static $validators = [
        //
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('partner', function ($builder) {
            if (app('auth')->user()) {
                $builder->where('partner', app('auth')->user()->code);
            }
        });
    }

    public static function getCompaniesFromElements($product)
    {
        $companies = [];
        $product = json_decode(json_encode($product));
        
        foreach ($product->elements as $element) {
            array_push($companies, $element->cmp);
        }

        return array_unique($companies);
    }
}

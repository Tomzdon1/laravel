<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Quote extends Eloquent
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        //
    ];

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

        static::addGlobalScope('partner', function($builder) {
            if (app('auth')->user()) {
                $builder->where('partner_id', app('auth')->user()->id);
            }
        });
    }
}

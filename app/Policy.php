<?php

namespace App;

use App\Events\CreatedPolicyEvent;

class Policy extends Model
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

        static::addGlobalScope('partner', function ($builder) {
            if (app('auth')->user()) {
                $builder->where('partner.code', app('auth')->user()->code);
            }
        });

        static::created(
            function ($policy) {
                event(new CreatedPolicyEvent($policy));
            }
        );
    }

    public function partnerModel()
    {
        return $this->belongsTo('App\Partner', 'partner_code', 'code');
    }

    public function getPartnerCodeAttribute()
    {
        return $this->partner->code;
    }

    public function travelOfferModel()
    {
        return $this->belongsTo('App\TravelOffer', 'product_id');
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function getStatuses()
    {
        return $this->statuses;
    }

    public function addStatus($status)
    {
        if (is_array($this->getStatuses())) {
            $this->statuses = array_merge($this->getStatuses(), [$status]);
        } else {
            $this->statuses = [$status];
        }
    }
}
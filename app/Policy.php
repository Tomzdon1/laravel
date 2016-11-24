<?php namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Events\IssuedPolicyEvent;

class Policy extends Eloquent 
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
     * Source of Policy
     *
     * @var string
     */
    private $source;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('partner', function($builder) {
            if(app('auth')->user()) {
                $builder->where('partner.code', app('auth')->user()->code);
            }
        });

        static::created(function($policy) {
            event(new IssuedPolicyEvent($policy));
        });
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getStatuses() {
        return $this->statuses;
    }

    public function addStatus($status) {
        if (is_array($this->getStatuses())) {
            $this->statuses = array_merge($this->getStatuses(), [$status]);
        } else {
            $this->statuses = [$status];
        }
    }
}

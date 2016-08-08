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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('partner', function(Builder $builder) {
            $builder->where('partner.code', app('auth')->user()->code);
        });

        static::created(function($policy) {
            event(new IssuedPolicyEvent($policy));
        });
    }

    public function fillFromImportRequest($importRequest, $importStatus, $partner = null) {
        if ($partner == null) {
            $partner = app('auth')->user();
        }
        
        $this->status = $importStatus->getStatus();
        $this->errors = $importStatus->getMessages();
        $this->quote_ref = $importStatus->getQuoteRef();

        $this->product_ref = $importRequest->getProductRef();
        $this->policy_date = $importRequest->getPolicyDate();
        $this->policy_number = $importRequest->getPolicyNumber();
        $this->start_date = $importRequest->getData()->getStartDate();
        $this->end_date = $importRequest->getData()->getEndDate();
        $this->abroad = $importRequest->getData()->getAbroad();
        $this->destination = $importRequest->getData()->getDestination();
        $this->policy_holder = $importRequest->getPolicyHolder();
        $this->insured = $importRequest->getInsured();
        $this->amount = $importRequest->getAmount();
        $this->tariff_amount = $importRequest->getTariffAmount();
        $this->netto_amount = $importRequest->getNettoAmount();
        $this->partner = $partner;
        $this->product = TravelOffer::find($this->product_ref);
        $this->DateTime = \DateTime::createFromFormat('U.u', microtime(true))->format("YmdHisu");
    }
}

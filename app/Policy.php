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

        static::addGlobalScope('partner', function(Builder $builder) {
            $builder->where('partner.code', app('auth')->user()->code);
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

    // @todo zastapic funkcje mapperem osobnym dla kazdego api
    public function fillFromImportRequest($importRequest, $importStatus, $partner = null) {
        if ($partner == null) {
            $partner = app('auth')->user();
        }

        $this->setSource('import');
        
        $this->status = $importStatus->getStatus();
        $this->errors = $importStatus->getMessages();
        
        // zgodnosc z api v1
        if (method_exists($importStatus, 'getQuoteRef')) {
            $this->quote_ref = $importStatus->getQuoteRef();
        }

        // zgodnosc z api v1
        if (method_exists($importRequest, 'getProductRef')) {
            $this->product_ref = $importRequest->getProductRef();
        } else {
            $this->product_id = $importRequest->getProductId();
        }

        $this->policy_date = $importRequest->getPolicyDate();
        $this->policy_number = $importRequest->getPolicyNumber();
        $this->start_date = $importRequest->getData()->getStartDate();
        $this->end_date = $importRequest->getData()->getEndDate();
        $this->abroad = $importRequest->getData()->getAbroad();
        $this->destination = $importRequest->getData()->getDestination();
        $this->policy_holder = $importRequest->getPolicyHolder();
        $this->insured = $importRequest->getInsured();
        $this->solicitors = $importRequest->getSolicitors();
        
        // zgodnosc z api v1
        if (method_exists($importRequest, 'getAmount')) {
            $this->premium = $importRequest->getAmount();
            $this->tariff_premium = $importRequest->getTariffAmount();
            $this->netto_premium = $importRequest->getNettoAmount();
        } else {
            $this->premium = $importRequest->getPremium();
            $this->tariff_premium = $importRequest->getTariffPremium();
            $this->netto_premium = $importRequest->getNettoPremium();
        }
        
        $this->partner = $partner;

        // zgodnosc z api v1
        if (isset($this->product_ref)) {
            $this->product = TravelOffer::find($this->product_ref);
        } else {
            $this->product = TravelOffer::find($this->product_id);
        }
        
        $this->DateTime = \DateTime::createFromFormat('U.u', microtime(true))->format("YmdHisu");
    }

    public function fillFromIssueRequest() {
        $this->source = 'issue';
    }
}

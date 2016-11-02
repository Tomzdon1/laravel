<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\QUOTEREQUEST;
use App\TravelOffer;
use App\apiModels\travel\v1\traits;

class QUOTEREQUESTImpl extends QUOTEREQUEST
{
    use traits\SwaggerDeserializationTrait;
    
    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        //
    ];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    public function getQuotes()
    {
        $partnerCode = app('auth')->user()->code;
        $offers = TravelOffer::where('partner', $partnerCode)->get();

        $quotes = [];
        $quoteNumber = 0;

        foreach ($offers as $offer) {
            $quote = new QUOTEImpl();
            $quote->setDescription($offer->name);
            $quote->setDetails($offer->elements);
            $quote->setOptionDefinitions($offer->options);
            $quote->setQuoteRef(app('request')->attributes->get('requestId') . $quoteNumber++);
            $quote->setOptionValues($this->getData()->getOptionValues());
            $quote->recalculateAmounts($offer, $this, false);
            $quotes[] = $quote;
        }

        return $quotes;
    }
}

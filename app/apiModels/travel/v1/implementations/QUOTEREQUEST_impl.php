<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\QUOTEREQUEST;
use App\TravelOffer;
use Symfony\Component\HttpFoundation\Response as Response;

/**
 * QUOTEREQUEST Class Doc Comment
 * @category    Class
 * @description 
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>   
 */
class QUOTEREQUEST_impl extends QUOTEREQUEST
{

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
        $travelOffers = TravelOffer::where('partner', $partnerCode)->get();

        $quotes = [];
        $quoteNumber = 0;

        foreach ($travelOffers as $travelOffer) {
            $quote = new QUOTE_impl();
            $quote->setVarCode($travelOffer->code);
            $quote->setDescription($travelOffer->name);
            $quote->setDetails($travelOffer->elements);
            $quote->setOptionDefinitions($travelOffer->options);
            $quote->setQuoteRef(app('request')->attributes->get('requestId') . $quoteNumber++);
            $quote->setOptionValues($this->getData()->getOptionValues());
            $quote->recalculateAmounts($travelOffer, $this);
            $quotes[] = $quote;
        }

        return $quotes;
    }
}

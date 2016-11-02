<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\CALCULATEREQUEST;
use App\TravelOffer;
use App\apiModels\travel\v1\traits;

class CALCULATEREQUESTImpl extends CALCULATEREQUEST
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

    public function calculate()
    {
        $partnerCode = app('auth')->user()->code;
        $offer = TravelOffer::find($this->getProductId());

        if ($offer) {
            $calculate = new CALCULATEImpl();
            $calculate->setRequest($this);
            $calculate->recalculateAmounts($offer, $this);
            return $calculate;
        }
    }
}

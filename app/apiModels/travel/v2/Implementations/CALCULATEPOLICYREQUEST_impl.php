<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\CALCULATEPOLICYREQUEST;
use App\TravelOffer;
use App\apiModels\travel\v2\Traits;

class CALCULATEPOLICYREQUEST_impl extends CALCULATEPOLICYREQUEST
{
    use Traits\SwaggerDeserializationTrait;
    use Traits\PremiumCalculatorTrait;
    
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
}

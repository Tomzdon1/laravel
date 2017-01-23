<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\CalculatePolicyRequest;
use App\TravelOffer;
use App\apiModels\travel\v2\Traits;

class CalculatePolicyRequestImpl extends CalculatePolicyRequest
{
    use Traits\SwaggerDeserializationTrait;
    use Traits\PremiumCalculatorTrait;
    
    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'data.start_date.date' => 'afterEqual:now',
        'data.configured_risks.*.start_date.date' => 'afterEqual:now'
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

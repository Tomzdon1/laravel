<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\QUOTE;
use App\apiModels\travel\v2\Traits;

class QUOTE_impl extends QUOTE
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

    /**
     * Override getInsureds function in AmountsCalculator trait to return preperson instead preperson
     */
    public function getInsureds ($quoteRequest) {
      return $quoteRequest->getPrepersons();
    }

}

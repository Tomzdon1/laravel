<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\QUOTE;
use App\apiModels\travel\v1\traits;

class QUOTEImpl extends QUOTE
{

    use traits\AmountsCalculator;
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

    /**
     * Override getInsureds function in AmountsCalculator trait to return preperson instead preperson
     */
    public function getInsureds($quoteRequest)
    {
        return $quoteRequest->getPrepersons();
    }
}

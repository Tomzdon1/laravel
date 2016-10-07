<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\CALCULATIONPOLICY;
use App\apiModels\travel\v2\Traits;

class CALCULATIONPOLICY_impl extends CALCULATIONPOLICY
{
    use Traits\SwaggerDeserializationTrait;

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

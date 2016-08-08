<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\CALCULATE;
use App\apiModels\travel\v1\traits\AmountsCalculator;

class CALCULATE_impl extends CALCULATE
{
    use AmountsCalculator;

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

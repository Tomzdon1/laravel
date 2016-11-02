<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\Premium;
use App\apiModels\travel\v2\Traits;

class PremiumImpl extends Premium
{
    use Traits\SwaggerDeserializationTrait;

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'value_base_currency'   => 'currency_code',
        'value_currency'        => 'currency_code',
        'value'                 => 'value_conversion:value_base,currency_rate,2',
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

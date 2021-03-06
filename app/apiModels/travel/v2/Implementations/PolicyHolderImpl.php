<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\PolicyHolder;
use App\apiModels\travel\v2\Traits;

class PolicyHolderImpl extends PolicyHolder
{
    use Traits\SwaggerDeserializationTrait;

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'data.pesel' => 'required_if:data.type,private',
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

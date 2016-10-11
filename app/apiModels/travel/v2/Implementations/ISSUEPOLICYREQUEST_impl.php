<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\ISSUEPOLICYREQUEST;
use App\apiModels\travel\v2\Traits;

class ISSUEPOLICYREQUEST_impl extends ISSUEPOLICYREQUEST
{
    use Traits\SwaggerDeserializationTrait;

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'calculation_id' => 'valid_calculation_id',
        'policy_date.date' => 'bail|before_equal:now|valid_calculation_due_date:calculation_id',
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

<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\IssuePolicyRequest;
use App\apiModels\travel\v2\Traits;

class IssuePolicyRequestImpl extends IssuePolicyRequest
{
    use Traits\SwaggerDeserializationTrait;

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'calculation_id' => 'valid_calculation_id',
        'policy_date.date' => 'valid_calculation_due_date:calculation_id',
        'payment_date' => 'before_equal:policy_date.date',
        'checksum' => 'valid_calculation_checksum:calculation_id'
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

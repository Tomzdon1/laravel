<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\ImportPolicyRequest;
use App\apiModels\travel\v2\Traits;

class ImportPolicyRequestImpl extends ImportPolicyRequest
{
    use Traits\SwaggerDeserializationTrait;
    use Traits\PremiumCalculatorTrait;

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'product_id' => 'product_ref',
        'policy_number' => 'unique:policies',
        'policy_date.date' => 'before_equal:data.start_date.date',
        'data.configured_risks.*.start_date.date' => 'afterEqual:policy_date.date'
    ];

    /**
     * Valdators for model (generates warning)
     * @var array
     */
    public static $warningValidators = [
        'tariff_premium.value_base' => 'bail|correct_calculation|amount_value',
        'netto_premium.value_base' => 'bail|correct_calculation|amount_value',
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

<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\PrintPolicyRequest;
use App\apiModels\travel\v2\Traits;

class PrintPolicyRequestImpl extends PrintPolicyRequest
{
    use Traits\SwaggerDeserializationTrait;

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'policy_id' => 'valid_policy_id',
        'checksum' => 'valid_policy_checksum:policy_id'
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

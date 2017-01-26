<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\ImportPolicyStatus;
use App\apiModels\travel\v2\Traits;

class ImportPolicyStatusImpl extends ImportPolicyStatus
{
    use Traits\SwaggerDeserializationTrait;
    
    const STATUS_OK = 'OK';
    const STATUS_WARN = 'WARN';
    const STATUS_ERR = 'ERR';

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
        $this->setMessages([]);
        parent::__construct($data);
    }

    /**
     * Add message
     * @param string $code
     * @param string $text
     * @return $this
     */
    public function addMessage($code, $text)
    {
        
        $this->messages[] = ['code' => $code, 'text' => $text];
        return $this;
    }
}

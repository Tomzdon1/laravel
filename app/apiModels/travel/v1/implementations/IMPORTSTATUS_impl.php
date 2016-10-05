<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\IMPORTSTATUS;
use App\apiModels\travel\v1\Traits;

/**
 * IMPORTSTATUS_impl Class Doc Comment
 * @category    Class
 * @description
 * @package     travel\v1
 * @author      Tomasz Duda <tomasz.duda@tueuropa.pl>
 */
class IMPORTSTATUS_impl extends IMPORTSTATUS
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

<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\SOLICITOR;
use App\apiModels\travel\v1\traits;

/**
 * SOLICITORImpl Class Doc Comment
 * @category    Class
 * @description
 * @package     travel\v1
 * @author      Tomasz Duda <tomasz.duda@tueuropa.pl>
 */
class SOLICITORImpl extends SOLICITOR
{
    use traits\SwaggerDeserializationTrait;
    
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

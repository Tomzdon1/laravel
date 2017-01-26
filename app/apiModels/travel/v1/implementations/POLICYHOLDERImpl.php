<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\POLICYHOLDER;
use App\apiModels\travel\v1\traits;

/**
 * CALCULATE_REQUEST Class Doc Comment
 * @category    Class
 * @description
 * @package     travel\v1
 * @author      Tomasz Duda <tomasz.duda@tueuropa.pl>
 */
class POLICYHOLDERImpl extends POLICYHOLDER
{
    use traits\SwaggerDeserializationTrait;
    
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

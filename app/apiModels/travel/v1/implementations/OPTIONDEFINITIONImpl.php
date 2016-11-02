<?php
/**
 * OPTIONDEFINITION
 *
 * PHP version 5
 *
 * @category    Class
 * @description
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */


namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\OPTIONDEFINITION;
use App\apiModels\travel\v1\traits;

class OPTIONDEFINITIONImpl extends OPTIONDEFINITION
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

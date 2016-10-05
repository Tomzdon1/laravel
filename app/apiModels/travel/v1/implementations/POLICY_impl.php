<?php

/**
 * POLICY
 *
 * PHP version 5
 *
 * @category    Class
 * @description
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\POLICY;
use App\apiModels\travel\v1\Traits;

class POLICY_impl extends POLICY
{
    use Traits\SwaggerDeserializationTrait;
    
    public static $validators = [];

    public function __construct(array $data = null)
    {

        parent::__construct($data);
    }
}

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

class POLICY_impl extends POLICY
{

    public static $validators = [];

    public function __construct(array $data = null)
    {

        parent::__construct($data);
    }
}

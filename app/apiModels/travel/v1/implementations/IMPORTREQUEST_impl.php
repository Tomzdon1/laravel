<?php

/**
 * IMPORTREQUEST_impl
 *
 * PHP version 5
 *
 * @category    Class
 * @description 
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\IMPORTREQUEST;

class IMPORTREQUEST_impl extends IMPORTREQUEST
{

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        // 'amount.value_base'    => 'promotional_amount:promo_code,tariff_amount.value_base,2',
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

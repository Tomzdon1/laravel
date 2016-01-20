<?php

/**
 * PERSONDATA
 *
 * PHP version 5
 *
 * @category    Class
 * @description 
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\PERSONDATA;

class PERSONDATA_impl extends PERSONDATA
{

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'birth_date' => 'before:today',
        'pesel' => 'pesel',
        'nationality' => 'countryCode',
    ];
    public static $swaggerTypes = array(
        'first_name' => 'string',
        'last_name' => 'string',
        'birth_date' => '\DateTime',
        'pesel' => 'string',
        'nationality' => 'string',
        'document_no' => 'string'
    );

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    public function getBirthDate()
    {
        return $this->birth_date->format('Y-m-d');
    }
}

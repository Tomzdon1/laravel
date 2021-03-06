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
use App\apiModels\travel\v1\traits;

class PERSONDATAImpl extends PERSONDATA
{
    use traits\SwaggerDeserializationTrait;
    
    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'birth_date.date' => 'required_if:type,private,foreigner|before:today',
        'business_name' => 'required_if:type,sole_trader,company',
        'nip' => 'required_if:type,sole_trader,company',
        'nationality' => 'sometimes|required_if:type,foreigner|countryCode',
        'document_no' => 'required_if:type,foreigner'
    ];

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
        return $this->birth_date instanceof DateTime ? $this->birth_date->format('Y-m-d') : $this->birth_date;
    }
}

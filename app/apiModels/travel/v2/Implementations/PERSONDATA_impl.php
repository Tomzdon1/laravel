<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\PERSONDATA;
use App\apiModels\travel\v2\Traits;

class PERSONDATA_impl extends PERSONDATA
{
    use Traits\SwaggerDeserializationTrait;

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'birth_date.date' => 'required_if:type,private|before:today',
        'nationality' => 'countryCode',
        'business_name' => 'required_if:type,sole_trader,company',
        'nip' => 'required_if:type,sole_trader,company'
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

<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\PersonData;
use App\apiModels\travel\v2\Interfaces\PersonInterface;
use App\apiModels\travel\v2\Traits;

class PersonDataImpl extends PersonData implements PersonInterface
{
    use Traits\SwaggerDeserializationTrait;

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'birth_date.date' => 'required_if:type,private,foreigner|before:today',
        'business_name' => 'required_if:type,sole_trader,company',
        'nip' => 'required_if:type,sole_trader,company',
        'nationality' => 'required_if:type,foreigner|countryCode',
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

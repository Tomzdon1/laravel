<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\INSURED;
use App\apiModels\travel\v1\Interfaces\PersonInterface;
use App\apiModels\travel\v2\Traits;

class INSURED_impl extends INSURED implements PersonInterface
{
    use Traits\SwaggerDeserializationTrait;

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

    public function getBirthDate()
    {
        return $this->getData()->getBirthDate();
    }

    public function setBirthDate($birth_date)
    {
        parent::setBirthDate($birth_date);
        $this->birth_date->setTimezone(new \DateTimeZone('Europe/Warsaw'));
    }
}

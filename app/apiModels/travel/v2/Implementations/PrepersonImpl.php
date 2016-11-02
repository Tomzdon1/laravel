<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\Preperson;
use App\apiModels\travel\v2\Interfaces\PrepersonInterface;
use App\apiModels\travel\v2\Traits;

class PrepersonImpl extends Preperson implements PrepersonInterface
{
    use Traits\SwaggerDeserializationTrait;

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'birth_date.date' => 'before:today',
    ];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    public function setBirthDate($birth_date)
    {
        parent::setBirthDate($birth_date);
        $this->birth_date->setTimezone(new \DateTimeZone('Europe/Warsaw'));
    }
}

<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\PREPERSON;
use App\apiModels\travel\v1\interfaces\PrePersonInterface;
use App\apiModels\travel\v1\traits;

class PREPERSONImpl extends PREPERSON implements PrePersonInterface
{
    use traits\SwaggerDeserializationTrait;
    
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

<?php

/**
 * PREPERSON
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\PREPERSON;

class PREPERSON_impl extends PREPERSON
{

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

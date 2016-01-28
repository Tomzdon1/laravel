<?php

/**
 * VALIDATIONERROR
 *
 * PHP version 5
 *
 * @category Class
 * @package  App\apiModels\travel\v1
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\VALIDATIONERROR;

class VALIDATIONERROR_impl extends VALIDATIONERROR
{

    /**
     * $property Nazwa atrybutu, którego dotyczą błędy
     * @var string
     */
    public $property;

    /**
     * $errors Tablica opisów błędów
     * @var string[]
     */
    public $errors = [];

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
}
<?php
/**
 * PERSONDATA
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
use App\apiModels\travel\v1\prototypes\PERSONDATA;

/**
 * PERSONDATA Class Doc Comment
 *
 * @category    Class
 * @description 
 * @package     Swagger\Client
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class PERSONDATA_impl extends PERSONDATA
{
    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'birth_date' => 'before:today',
        'pesel' => 'pesel',
        'nationality' => 'country',
        
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
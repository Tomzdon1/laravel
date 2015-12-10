<?php
/**
 * AMOUNT
 *
 * PHP version 5
 *
 * @category    Class
 * @description 
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */

namespace App\apiModels\travel\v1\implementations;

use \App\apiModels\travel\v1\prototypes\ADDRESS;
/**
 * AMOUNT Class Doc Comment
 *
 * @category    Class
 * @description 
 * @package     Swagger\Client
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ADDRESS_impl extends ADDRESS
{
	/**
     * Valdators for model
     * @var array
     */
    public static $validators = [
//        'value_base_currency' => 'currency_code',
//        'value_currency' => 'currency_code',
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

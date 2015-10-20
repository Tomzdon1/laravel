<?php
/**
 * DETAIL
 *
 * PHP version 5
 *
 * @category    Class
 * @description 
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */


namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\DETAIL;
/**
 * DETAIL Class Doc Comment
 *
 * @category    Class
 * @description Detal oferty
 * @package     App\apiModels\travel\v1
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class DETAIL_impl extends DETAIL
{
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

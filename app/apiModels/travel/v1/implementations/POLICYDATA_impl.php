<?php
/**
 * POLICYDATA
 *
 * PHP version 5
 *
 * @category    Class
 * @description 
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */


namespace App\apiModels\travel\v1\implementations;
use App\apiModels\travel\v1\prototypes\POLICYDATA;

/**
 * POLICYDATA Class Doc Comment
 *
 * @category    Class
 * @description 
 * @package     Swagger\Client
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class POLICYDATA_impl extends POLICYDATA
{
    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'start_date' => 'after_equal:today',
        'end_date'   => 'after:start_date',
        'destination'=> 'destination_code',
        'email' => 'email',
    ];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }
    
    public function setStartDate($start_date)
    {
        parent::setStartDate($start_date);
        $this->start_date->setTimezone(new \DateTimeZone('Europe/Warsaw')); 
    }
    public function setEndDate($start_date)
    {
        parent::setEndDate($start_date);
        $this->end_date->setTimezone(new \DateTimeZone('Europe/Warsaw')); 
    }
    
}

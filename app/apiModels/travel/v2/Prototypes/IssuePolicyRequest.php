<?php
/**
 * IssuePolicyRequest
 *
 * PHP version 5
 *
 * @category Class
 * @package  App\apiModels\travel\v2
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */
/**
 *  Copyright 2015 SmartBear Software
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace App\apiModels\travel\v2\Prototypes ;

use \ArrayAccess;
/**
 * IssuePolicyRequest Class Doc Comment
 *
 * @category    Class
 * @description Zestaw danych do stworzenia polisy
 * @package     App\apiModels\travel\v2
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class IssuePolicyRequest extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'calculation_id' => 'string',
        'payment_date' => '\DateTime',
        'policy_date' => '\DateTime',
        'solicitors' => 'App\apiModels\travel\v2\Prototypes\Solicitor[]',
        'checksum' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'calculation_id' => 'calculation_id',
        'payment_date' => 'payment_date',
        'policy_date' => 'policy_date',
        'solicitors' => 'solicitors',
        'checksum' => 'checksum'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'calculation_id' => 'setCalculationId',
        'payment_date' => 'setPaymentDate',
        'policy_date' => 'setPolicyDate',
        'solicitors' => 'setSolicitors',
        'checksum' => 'setChecksum'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'calculation_id' => 'getCalculationId',
        'payment_date' => 'getPaymentDate',
        'policy_date' => 'getPolicyDate',
        'solicitors' => 'getSolicitors',
        'checksum' => 'getChecksum'
    );
  
    
    /**
      * $calculation_id Identyfikator kalkulacji
      * @var string
      */
    public $calculation_id;
    
    /**
      * $payment_date Data zapłaty
      * @var \DateTime
      */
    public $payment_date;
    
    /**
      * $policy_date Data zawarcia polisy
      * @var \DateTime
      */
    public $policy_date;
    
    /**
      * $solicitors Informacje o OWCA biorących udział w sprzedaży polisy; Wartości tego pola są weryfikowane a dokładnie uprawnienia agenta/owca do sprzedaży danego typu polisy
      * @var App\apiModels\travel\v2\Prototypes\Solicitor[]
      */
    public $solicitors;
    
    /**
      * $checksum Suma kontrolna kalkulacji
      * @var string
      */
    public $checksum;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->calculation_id = $data["calculation_id"];
            $this->payment_date = $data["payment_date"];
            $this->policy_date = $data["policy_date"];
            $this->solicitors = $data["solicitors"];
            $this->checksum = $data["checksum"];
        }
    }
    
    /**
     * Gets calculation_id
     * @return string
     */
    public function getCalculationId()
    {
        return $this->calculation_id;
    }
  
    /**
     * Sets calculation_id
     * @param string $calculation_id Identyfikator kalkulacji
     * @return $this
     */
    public function setCalculationId($calculation_id)
    {
        
        $this->calculation_id = $calculation_id;
        return $this;
    }
    
    /**
     * Gets payment_date
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->payment_date;
    }
  
    /**
     * Sets payment_date
     * @param \DateTime $payment_date Data zapłaty
     * @return $this
     */
    public function setPaymentDate($payment_date)
    {
        
        $this->payment_date = $payment_date;
        return $this;
    }
    
    /**
     * Gets policy_date
     * @return \DateTime
     */
    public function getPolicyDate()
    {
        return $this->policy_date;
    }
  
    /**
     * Sets policy_date
     * @param \DateTime $policy_date Data zawarcia polisy
     * @return $this
     */
    public function setPolicyDate($policy_date)
    {
        
        $this->policy_date = $policy_date;
        return $this;
    }
    
    /**
     * Gets solicitors
     * @return App\apiModels\travel\v2\Prototypes\Solicitor[]
     */
    public function getSolicitors()
    {
        return $this->solicitors;
    }
  
    /**
     * Sets solicitors
     * @param App\apiModels\travel\v2\Prototypes\Solicitor[] $solicitors Informacje o OWCA biorących udział w sprzedaży polisy; Wartości tego pola są weryfikowane a dokładnie uprawnienia agenta/owca do sprzedaży danego typu polisy
     * @return $this
     */
    public function setSolicitors($solicitors)
    {
        
        $this->solicitors = $solicitors;
        return $this;
    }
    
    /**
     * Gets checksum
     * @return string
     */
    public function getChecksum()
    {
        return $this->checksum;
    }
  
    /**
     * Sets checksum
     * @param string $checksum Suma kontrolna kalkulacji
     * @return $this
     */
    public function setChecksum($checksum)
    {
        
        $this->checksum = $checksum;
        return $this;
    }
    
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset 
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }
  
    /**
     * Gets offset.
     * @param  integer $offset Offset 
     * @return mixed 
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }
  
    /**
     * Sets value based on offset.
     * @param  integer $offset Offset 
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }
  
    /**
     * Unsets offset.
     * @param  integer $offset Offset 
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
  
    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
        } else {
            return json_encode(get_object_vars($this));
        }
    }
}

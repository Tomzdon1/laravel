<?php
/**
 * CALCULATIONPOLICY
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
 * CALCULATIONPOLICY Class Doc Comment
 *
 * @category    Class
 * @description Kalkulacja
 * @package     App\apiModels\travel\v2
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class CALCULATIONPOLICY extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'calculation_id' => 'string',
        'premium' => 'App\apiModels\travel\v2\Prototypes\PREMIUM',
        'tariff_premium' => 'App\apiModels\travel\v2\Prototypes\PREMIUM',
        'due_date' => '\DateTime',
        'checksum' => 'string',
        'promo_code_valid' => 'bool'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'calculation_id' => 'calculation_id',
        'premium' => 'premium',
        'tariff_premium' => 'tariff_premium',
        'due_date' => 'due_date',
        'checksum' => 'checksum',
        'promo_code_valid' => 'promo_code_valid'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'calculation_id' => 'setCalculationId',
        'premium' => 'setPremium',
        'tariff_premium' => 'setTariffPremium',
        'due_date' => 'setDueDate',
        'checksum' => 'setChecksum',
        'promo_code_valid' => 'setPromoCodeValid'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'calculation_id' => 'getCalculationId',
        'premium' => 'getPremium',
        'tariff_premium' => 'getTariffPremium',
        'due_date' => 'getDueDate',
        'checksum' => 'getChecksum',
        'promo_code_valid' => 'getPromoCodeValid'
    );
  
    
    /**
      * $calculation_id Identyfikator kalkulacji
      * @var string
      */
    public $calculation_id;
    
    /**
      * $premium Składka pobrana/należna
      * @var App\apiModels\travel\v2\Prototypes\PREMIUM
      */
    public $premium;
    
    /**
      * $tariff_premium Składka wynikająca z taryfy
      * @var App\apiModels\travel\v2\Prototypes\PREMIUM
      */
    public $tariff_premium;
    
    /**
      * $due_date Data ważności kalkulacji
      * @var \DateTime
      */
    public $due_date;
    
    /**
      * $checksum Suma kontrolna kalkulacji
      * @var string
      */
    public $checksum;
    
    /**
      * $promo_code_valid Czy kod promocyjny jest ważny i został uwzględniony
      * @var bool
      */
    public $promo_code_valid;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->calculation_id = $data["calculation_id"];
            $this->premium = $data["premium"];
            $this->tariff_premium = $data["tariff_premium"];
            $this->due_date = $data["due_date"];
            $this->checksum = $data["checksum"];
            $this->promo_code_valid = $data["promo_code_valid"];
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
     * Gets premium
     * @return App\apiModels\travel\v2\Prototypes\PREMIUM
     */
    public function getPremium()
    {
        return $this->premium;
    }
  
    /**
     * Sets premium
     * @param App\apiModels\travel\v2\Prototypes\PREMIUM $premium Składka pobrana/należna
     * @return $this
     */
    public function setPremium($premium)
    {
        
        $this->premium = $premium;
        return $this;
    }
    
    /**
     * Gets tariff_premium
     * @return App\apiModels\travel\v2\Prototypes\PREMIUM
     */
    public function getTariffPremium()
    {
        return $this->tariff_premium;
    }
  
    /**
     * Sets tariff_premium
     * @param App\apiModels\travel\v2\Prototypes\PREMIUM $tariff_premium Składka wynikająca z taryfy
     * @return $this
     */
    public function setTariffPremium($tariff_premium)
    {
        
        $this->tariff_premium = $tariff_premium;
        return $this;
    }
    
    /**
     * Gets due_date
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->due_date;
    }
  
    /**
     * Sets due_date
     * @param \DateTime $due_date Data ważności kalkulacji
     * @return $this
     */
    public function setDueDate($due_date)
    {
        
        $this->due_date = $due_date;
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
     * Gets promo_code_valid
     * @return bool
     */
    public function getPromoCodeValid()
    {
        return $this->promo_code_valid;
    }
  
    /**
     * Sets promo_code_valid
     * @param bool $promo_code_valid Czy kod promocyjny jest ważny i został uwzględniony
     * @return $this
     */
    public function setPromoCodeValid($promo_code_valid)
    {
        
        $this->promo_code_valid = $promo_code_valid;
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

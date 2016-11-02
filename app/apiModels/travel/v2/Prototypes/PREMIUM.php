<?php
/**
 * Premium
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
 * Premium Class Doc Comment
 *
 * @category    Class
 * @description Składka
 * @package     App\apiModels\travel\v2
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Premium extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'value_base' => 'float',
        'value_base_currency' => 'string',
        'value' => 'float',
        'value_currency' => 'string',
        'currency_rate' => 'float',
        'date_rate' => '\DateTime'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'value_base' => 'value_base',
        'value_base_currency' => 'value_base_currency',
        'value' => 'value',
        'value_currency' => 'value_currency',
        'currency_rate' => 'currency_rate',
        'date_rate' => 'date_rate'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'value_base' => 'setValueBase',
        'value_base_currency' => 'setValueBaseCurrency',
        'value' => 'setValue',
        'value_currency' => 'setValueCurrency',
        'currency_rate' => 'setCurrencyRate',
        'date_rate' => 'setDateRate'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'value_base' => 'getValueBase',
        'value_base_currency' => 'getValueBaseCurrency',
        'value' => 'getValue',
        'value_currency' => 'getValueCurrency',
        'currency_rate' => 'getCurrencyRate',
        'date_rate' => 'getDateRate'
    );
  
    
    /**
      * $value_base Kwota składki w walucie podstawowej
      * @var float
      */
    public $value_base;
    
    /**
      * $value_base_currency Waluta podstawowa (kod waluty zgodny z ISO 4217)
      * @var string
      */
    public $value_base_currency;
    
    /**
      * $value Kwota składki
      * @var float
      */
    public $value;
    
    /**
      * $value_currency Waluta (kod waluty zgodny z ISO 4217)
      * @var string
      */
    public $value_currency;
    
    /**
      * $currency_rate Kurs waluty
      * @var float
      */
    public $currency_rate;
    
    /**
      * $date_rate Data kursu
      * @var \DateTime
      */
    public $date_rate;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->value_base = $data["value_base"];
            $this->value_base_currency = $data["value_base_currency"];
            $this->value = $data["value"];
            $this->value_currency = $data["value_currency"];
            $this->currency_rate = $data["currency_rate"];
            $this->date_rate = $data["date_rate"];
        }
    }
    
    /**
     * Gets value_base
     * @return float
     */
    public function getValueBase()
    {
        return $this->value_base;
    }
  
    /**
     * Sets value_base
     * @param float $value_base Kwota składki w walucie podstawowej
     * @return $this
     */
    public function setValueBase($value_base)
    {
        
        $this->value_base = $value_base;
        return $this;
    }
    
    /**
     * Gets value_base_currency
     * @return string
     */
    public function getValueBaseCurrency()
    {
        return $this->value_base_currency;
    }
  
    /**
     * Sets value_base_currency
     * @param string $value_base_currency Waluta podstawowa (kod waluty zgodny z ISO 4217)
     * @return $this
     */
    public function setValueBaseCurrency($value_base_currency)
    {
        
        $this->value_base_currency = $value_base_currency;
        return $this;
    }
    
    /**
     * Gets value
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }
  
    /**
     * Sets value
     * @param float $value Kwota składki
     * @return $this
     */
    public function setValue($value)
    {
        
        $this->value = $value;
        return $this;
    }
    
    /**
     * Gets value_currency
     * @return string
     */
    public function getValueCurrency()
    {
        return $this->value_currency;
    }
  
    /**
     * Sets value_currency
     * @param string $value_currency Waluta (kod waluty zgodny z ISO 4217)
     * @return $this
     */
    public function setValueCurrency($value_currency)
    {
        
        $this->value_currency = $value_currency;
        return $this;
    }
    
    /**
     * Gets currency_rate
     * @return float
     */
    public function getCurrencyRate()
    {
        return $this->currency_rate;
    }
  
    /**
     * Sets currency_rate
     * @param float $currency_rate Kurs waluty
     * @return $this
     */
    public function setCurrencyRate($currency_rate)
    {
        
        $this->currency_rate = $currency_rate;
        return $this;
    }
    
    /**
     * Gets date_rate
     * @return \DateTime
     */
    public function getDateRate()
    {
        return $this->date_rate;
    }
  
    /**
     * Sets date_rate
     * @param \DateTime $date_rate Data kursu
     * @return $this
     */
    public function setDateRate($date_rate)
    {
        
        $this->date_rate = $date_rate;
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

<?php
/**
 * QUOTE
 *
 * PHP version 5
 *
 * @category Class
 * @package  App\apiModels\travel\v1
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

namespace App\apiModels\travel\v1\prototypes ;

use \ArrayAccess;
/**
 * QUOTE Class Doc Comment
 *
 * @category    Class
 * @description Oferta
 * @package     App\apiModels\travel\v1
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class QUOTE extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'quote_ref' => 'string',
        'amount' => 'App\apiModels\travel\v1\prototypes\AMOUNT',
        'promo_code_valid' => 'bool',
        'description' => 'string',
        'details' => 'App\apiModels\travel\v1\prototypes\DETAIL[]',
        'option_definitions' => 'App\apiModels\travel\v1\prototypes\OPTIONDEFINITION[]',
        'option_values' => 'App\apiModels\travel\v1\prototypes\OPTIONVALUE[]'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'quote_ref' => 'quote_ref',
        'amount' => 'amount',
        'promo_code_valid' => 'promo_code_valid',
        'description' => 'description',
        'details' => 'details',
        'option_definitions' => 'option_definitions',
        'option_values' => 'option_values'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'quote_ref' => 'setQuoteRef',
        'amount' => 'setAmount',
        'promo_code_valid' => 'setPromoCodeValid',
        'description' => 'setDescription',
        'details' => 'setDetails',
        'option_definitions' => 'setOptionDefinitions',
        'option_values' => 'setOptionValues'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'quote_ref' => 'getQuoteRef',
        'amount' => 'getAmount',
        'promo_code_valid' => 'getPromoCodeValid',
        'description' => 'getDescription',
        'details' => 'getDetails',
        'option_definitions' => 'getOptionDefinitions',
        'option_values' => 'getOptionValues'
    );
  
    
    /**
      * $quote_ref Identyfikator oferty
      * @var string
      */
    public $quote_ref;
    
    /**
      * $amount Składka
      * @var App\apiModels\travel\v1\prototypes\AMOUNT
      */
    public $amount;
    
    /**
      * $promo_code_valid Czy kod promocyjny jest prawidłowy
      * @var bool
      */
    public $promo_code_valid;
    
    /**
      * $description Opis wariantu
      * @var string
      */
    public $description;
    
    /**
      * $details Tablica detali oferty
      * @var App\apiModels\travel\v1\prototypes\DETAIL[]
      */
    public $details;
    
    /**
      * $option_definitions Definicje atrybutów, które można użyć do kalkulacji (nie wolno zmieniać wartości atrybutów, dla których pole changable == false)
      * @var App\apiModels\travel\v1\prototypes\OPTIONDEFINITION[]
      */
    public $option_definitions;
    
    /**
      * $option_values Wartości, które zostały użyte do kalkulacji
      * @var App\apiModels\travel\v1\prototypes\OPTIONVALUE[]
      */
    public $option_values;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->quote_ref = $data["quote_ref"];
            $this->amount = $data["amount"];
            $this->promo_code_valid = $data["promo_code_valid"];
            $this->description = $data["description"];
            $this->details = $data["details"];
            $this->option_definitions = $data["option_definitions"];
            $this->option_values = $data["option_values"];
        }
    }
    
    /**
     * Gets quote_ref
     * @return string
     */
    public function getQuoteRef()
    {
        return $this->quote_ref;
    }
  
    /**
     * Sets quote_ref
     * @param string $quote_ref Identyfikator oferty
     * @return $this
     */
    public function setQuoteRef($quote_ref)
    {
        
        $this->quote_ref = $quote_ref;
        return $this;
    }
    
    /**
     * Gets amount
     * @return App\apiModels\travel\v1\prototypes\AMOUNT
     */
    public function getAmount()
    {
        return $this->amount;
    }
  
    /**
     * Sets amount
     * @param App\apiModels\travel\v1\prototypes\AMOUNT $amount Składka
     * @return $this
     */
    public function setAmount($amount)
    {
        
        $this->amount = $amount;
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
     * @param bool $promo_code_valid Czy kod promocyjny jest prawidłowy
     * @return $this
     */
    public function setPromoCodeValid($promo_code_valid)
    {
        
        $this->promo_code_valid = $promo_code_valid;
        return $this;
    }
    
    /**
     * Gets description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
  
    /**
     * Sets description
     * @param string $description Opis wariantu
     * @return $this
     */
    public function setDescription($description)
    {
        
        $this->description = $description;
        return $this;
    }
    
    /**
     * Gets details
     * @return App\apiModels\travel\v1\prototypes\DETAIL[]
     */
    public function getDetails()
    {
        return $this->details;
    }
  
    /**
     * Sets details
     * @param App\apiModels\travel\v1\prototypes\DETAIL[] $details Tablica detali oferty
     * @return $this
     */
    public function setDetails($details)
    {
        
        $this->details = $details;
        return $this;
    }
    
    /**
     * Gets option_definitions
     * @return App\apiModels\travel\v1\prototypes\OPTIONDEFINITION[]
     */
    public function getOptionDefinitions()
    {
        return $this->option_definitions;
    }
  
    /**
     * Sets option_definitions
     * @param App\apiModels\travel\v1\prototypes\OPTIONDEFINITION[] $option_definitions Definicje atrybutów, które można użyć do kalkulacji (nie wolno zmieniać wartości atrybutów, dla których pole changable == false)
     * @return $this
     */
    public function setOptionDefinitions($option_definitions)
    {
        
        $this->option_definitions = $option_definitions;
        return $this;
    }
    
    /**
     * Gets option_values
     * @return App\apiModels\travel\v1\prototypes\OPTIONVALUE[]
     */
    public function getOptionValues()
    {
        return $this->option_values;
    }
  
    /**
     * Sets option_values
     * @param App\apiModels\travel\v1\prototypes\OPTIONVALUE[] $option_values Wartości, które zostały użyte do kalkulacji
     * @return $this
     */
    public function setOptionValues($option_values)
    {
        
        $this->option_values = $option_values;
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

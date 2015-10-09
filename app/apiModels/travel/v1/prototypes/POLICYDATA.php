<?php
/**
 * POLICYDATA
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

namespace App\apiModels\travel\v1\prototypes;

use \ArrayAccess;
/**
 * POLICYDATA Class Doc Comment
 *
 * @category    Class
 * @description Dane polisy
 * @package     App\apiModels\travel\v1
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class POLICYDATA implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'promo_code' => 'string',
        'start_date' => '\DateTime',
        'end_date' => '\DateTime',
        'abroad' => 'bool',
        'family' => 'bool',
        'destination' => 'string',
        'option_values' => 'App\apiModels\travel\v1\prototypes\OPTIONVALUE[]'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'promo_code' => 'promo_code',
        'start_date' => 'start_date',
        'end_date' => 'end_date',
        'abroad' => 'abroad',
        'family' => 'family',
        'destination' => 'destination',
        'option_values' => 'option_values'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'promo_code' => 'setPromoCode',
        'start_date' => 'setStartDate',
        'end_date' => 'setEndDate',
        'abroad' => 'setAbroad',
        'family' => 'setFamily',
        'destination' => 'setDestination',
        'option_values' => 'setOptionValues'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'promo_code' => 'getPromoCode',
        'start_date' => 'getStartDate',
        'end_date' => 'getEndDate',
        'abroad' => 'getAbroad',
        'family' => 'getFamily',
        'destination' => 'getDestination',
        'option_values' => 'getOptionValues'
    );
  
    
    /**
      * $promo_code Kod promocyjny
      * @var string
      */
    protected $promo_code;
    
    /**
      * $start_date Data rozpoczęcia ochrony
      * @var \DateTime
      */
    protected $start_date;
    
    /**
      * $end_date Data zakończenia ochrony
      * @var \DateTime
      */
    protected $end_date;
    
    /**
      * $abroad Czy ubezpieczony przebywa za granicą Polskiw momencie przystąpienia do ubezpieczenia (jeżeli tak jego ubezpieczenie może rozpocząć się (start_date) najwcześniej po upływie 2 dni od daty zawarcia ubezpieczenia)
      * @var bool
      */
    protected $abroad;
    
    /**
      * $family Czy wybrano wariant rodzinny
      * @var bool
      */
    protected $family;
    
    /**
      * $destination Cel podróży (kod kraju określony w ISO 3166-1 alpha-2 lub EU - Unia Europejska lub WR - świat)
      * @var string
      */
    protected $destination;
    
    /**
      * $option_values Tablica wartości dodatkowych atrybutów
      * @var App\apiModels\travel\v1\prototypes\OPTIONVALUE[]
      */
    protected $option_values;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->promo_code = $data["promo_code"];
            $this->start_date = $data["start_date"];
            $this->end_date = $data["end_date"];
            $this->abroad = $data["abroad"];
            $this->family = $data["family"];
            $this->destination = $data["destination"];
            $this->option_values = $data["option_values"];
        }
    }
    
    /**
     * Gets promo_code
     * @return string
     */
    public function getPromoCode()
    {
        return $this->promo_code;
    }
  
    /**
     * Sets promo_code
     * @param string $promo_code Kod promocyjny
     * @return $this
     */
    public function setPromoCode($promo_code)
    {
        
        $this->promo_code = $promo_code;
        return $this;
    }
    
    /**
     * Gets start_date
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }
  
    /**
     * Sets start_date
     * @param \DateTime $start_date Data rozpoczęcia ochrony
     * @return $this
     */
    public function setStartDate($start_date)
    {
        
        $this->start_date = $start_date;
        return $this;
    }
    
    /**
     * Gets end_date
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }
  
    /**
     * Sets end_date
     * @param \DateTime $end_date Data zakończenia ochrony
     * @return $this
     */
    public function setEndDate($end_date)
    {
        
        $this->end_date = $end_date;
        return $this;
    }
    
    /**
     * Gets abroad
     * @return bool
     */
    public function getAbroad()
    {
        return $this->abroad;
    }
  
    /**
     * Sets abroad
     * @param bool $abroad Czy ubezpieczony przebywa za granicą Polskiw momencie przystąpienia do ubezpieczenia (jeżeli tak jego ubezpieczenie może rozpocząć się (start_date) najwcześniej po upływie 2 dni od daty zawarcia ubezpieczenia)
     * @return $this
     */
    public function setAbroad($abroad)
    {
        
        $this->abroad = $abroad;
        return $this;
    }
    
    /**
     * Gets family
     * @return bool
     */
    public function getFamily()
    {
        return $this->family;
    }
  
    /**
     * Sets family
     * @param bool $family Czy wybrano wariant rodzinny
     * @return $this
     */
    public function setFamily($family)
    {
        
        $this->family = $family;
        return $this;
    }
    
    /**
     * Gets destination
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }
  
    /**
     * Sets destination
     * @param string $destination Cel podróży (kod kraju określony w ISO 3166-1 alpha-2 lub EU - Unia Europejska lub WR - świat)
     * @return $this
     */
    public function setDestination($destination)
    {
        
        $this->destination = $destination;
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
     * @param App\apiModels\travel\v1\prototypes\OPTIONVALUE[] $option_values Tablica wartości dodatkowych atrybutów
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

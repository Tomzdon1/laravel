<?php
/**
 * Preperson
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
 * Preperson Class Doc Comment
 *
 * @category    Class
 * @description Podstawowe dane osobowe
 * @package     App\apiModels\travel\v2
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Preperson extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'birth_date' => '\DateTime',
        'options' => 'App\apiModels\travel\v2\Prototypes\OptionValue[]',
        'addons' => 'App\apiModels\travel\v2\Prototypes\OptionValue[]'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'birth_date' => 'birth_date',
        'options' => 'options',
        'addons' => 'addons'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'birth_date' => 'setBirthDate',
        'options' => 'setOptions',
        'addons' => 'setAddons'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'birth_date' => 'getBirthDate',
        'options' => 'getOptions',
        'addons' => 'getAddons'
    );
  
    
    /**
      * $birth_date Data urodzenia
      * @var \DateTime
      */
    public $birth_date;
    
    /**
      * $options Wybrane opcje dodatkowe
      * @var App\apiModels\travel\v2\Prototypes\OptionValue[]
      */
    public $options;
    
    /**
      * $addons Dodatkowe atrybuty
      * @var App\apiModels\travel\v2\Prototypes\OptionValue[]
      */
    public $addons;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->birth_date = $data["birth_date"];
            $this->options = $data["options"];
            $this->addons = $data["addons"];
        }
    }
    
    /**
     * Gets birth_date
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }
  
    /**
     * Sets birth_date
     * @param \DateTime $birth_date Data urodzenia
     * @return $this
     */
    public function setBirthDate($birth_date)
    {
        
        $this->birth_date = $birth_date;
        return $this;
    }
    
    /**
     * Gets options
     * @return App\apiModels\travel\v2\Prototypes\OptionValue[]
     */
    public function getOptions()
    {
        return $this->options;
    }
  
    /**
     * Sets options
     * @param App\apiModels\travel\v2\Prototypes\OptionValue[] $options Wybrane opcje dodatkowe
     * @return $this
     */
    public function setOptions($options)
    {
        
        $this->options = $options;
        return $this;
    }
    
    /**
     * Gets addons
     * @return App\apiModels\travel\v2\Prototypes\OptionValue[]
     */
    public function getAddons()
    {
        return $this->addons;
    }
  
    /**
     * Sets addons
     * @param App\apiModels\travel\v2\Prototypes\OptionValue[] $addons Dodatkowe atrybuty
     * @return $this
     */
    public function setAddons($addons)
    {
        
        $this->addons = $addons;
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

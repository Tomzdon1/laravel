<?php
/**
 * Possession
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
 * Possession Class Doc Comment
 *
 * @category    Class
 * @description Mienie
 * @package     App\apiModels\travel\v2
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Possession extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'name' => 'string',
        'id' => 'string',
        'value' => 'float',
        'address' => 'App\apiModels\travel\v2\Prototypes\Address',
        'type' => 'string',
        'attributes' => 'App\apiModels\travel\v2\Prototypes\OptionValue[]'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'name' => 'name',
        'id' => 'id',
        'value' => 'value',
        'address' => 'address',
        'type' => 'type',
        'attributes' => 'attributes'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'name' => 'setName',
        'id' => 'setId',
        'value' => 'setValue',
        'address' => 'setAddress',
        'type' => 'setType',
        'attributes' => 'setAttributes'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'name' => 'getName',
        'id' => 'getId',
        'value' => 'getValue',
        'address' => 'getAddress',
        'type' => 'getType',
        'attributes' => 'getAttributes'
    );
  
    
    /**
      * $name Nazwa mienia
      * @var string
      */
    public $name;
    
    /**
      * $id Identyfikator mienia
      * @var string
      */
    public $id;
    
    /**
      * $value Wartość mienia
      * @var float
      */
    public $value;
    
    /**
      * $address 
      * @var App\apiModels\travel\v2\Prototypes\Address
      */
    public $address;
    
    /**
      * $type Typ mienia
      * @var string
      */
    public $type;
    
    /**
      * $attributes Atrybuty dodatkowe
      * @var App\apiModels\travel\v2\Prototypes\OptionValue[]
      */
    public $attributes;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->name = $data["name"];
            $this->id = $data["id"];
            $this->value = $data["value"];
            $this->address = $data["address"];
            $this->type = $data["type"];
            $this->attributes = $data["attributes"];
        }
    }
    
    /**
     * Gets name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
  
    /**
     * Sets name
     * @param string $name Nazwa mienia
     * @return $this
     */
    public function setName($name)
    {
        
        $this->name = $name;
        return $this;
    }
    
    /**
     * Gets id
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
  
    /**
     * Sets id
     * @param string $id Identyfikator mienia
     * @return $this
     */
    public function setId($id)
    {
        
        $this->id = $id;
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
     * @param float $value Wartość mienia
     * @return $this
     */
    public function setValue($value)
    {
        
        $this->value = $value;
        return $this;
    }
    
    /**
     * Gets address
     * @return App\apiModels\travel\v2\Prototypes\Address
     */
    public function getAddress()
    {
        return $this->address;
    }
  
    /**
     * Sets address
     * @param App\apiModels\travel\v2\Prototypes\Address $address 
     * @return $this
     */
    public function setAddress($address)
    {
        
        $this->address = $address;
        return $this;
    }
    
    /**
     * Gets type
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
  
    /**
     * Sets type
     * @param string $type Typ mienia
     * @return $this
     */
    public function setType($type)
    {
        
        $this->type = $type;
        return $this;
    }
    
    /**
     * Gets attributes
     * @return App\apiModels\travel\v2\Prototypes\OptionValue[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
  
    /**
     * Sets attributes
     * @param App\apiModels\travel\v2\Prototypes\OptionValue[] $attributes Atrybuty dodatkowe
     * @return $this
     */
    public function setAttributes($attributes)
    {
        
        $this->attributes = $attributes;
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

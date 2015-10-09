<?php
/**
 * ADDRESS
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
 * ADDRESS Class Doc Comment
 *
 * @category    Class
 * @description Dane adresowe
 * @package     App\apiModels\travel\v1
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ADDRESS implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'country' => 'string',
        'post_code' => 'string',
        'city' => 'string',
        'street' => 'string',
        'house_no' => 'string',
        'flat_no' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'country' => 'country',
        'post_code' => 'post_code',
        'city' => 'city',
        'street' => 'street',
        'house_no' => 'house_no',
        'flat_no' => 'flat_no'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'country' => 'setCountry',
        'post_code' => 'setPostCode',
        'city' => 'setCity',
        'street' => 'setStreet',
        'house_no' => 'setHouseNo',
        'flat_no' => 'setFlatNo'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'country' => 'getCountry',
        'post_code' => 'getPostCode',
        'city' => 'getCity',
        'street' => 'getStreet',
        'house_no' => 'getHouseNo',
        'flat_no' => 'getFlatNo'
    );
  
    
    /**
      * $country Kraj (kod kraju zgodny z ISO 3166-1 alpha-2)
      * @var string
      */
    protected $country;
    
    /**
      * $post_code Kod pocztowy
      * @var string
      */
    protected $post_code;
    
    /**
      * $city Miejscowość
      * @var string
      */
    protected $city;
    
    /**
      * $street Ulica
      * @var string
      */
    protected $street;
    
    /**
      * $house_no Numer domu
      * @var string
      */
    protected $house_no;
    
    /**
      * $flat_no Numer mieszkania
      * @var string
      */
    protected $flat_no;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->country = $data["country"];
            $this->post_code = $data["post_code"];
            $this->city = $data["city"];
            $this->street = $data["street"];
            $this->house_no = $data["house_no"];
            $this->flat_no = $data["flat_no"];
        }
    }
    
    /**
     * Gets country
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
  
    /**
     * Sets country
     * @param string $country Kraj (kod kraju zgodny z ISO 3166-1 alpha-2)
     * @return $this
     */
    public function setCountry($country)
    {
        
        $this->country = $country;
        return $this;
    }
    
    /**
     * Gets post_code
     * @return string
     */
    public function getPostCode()
    {
        return $this->post_code;
    }
  
    /**
     * Sets post_code
     * @param string $post_code Kod pocztowy
     * @return $this
     */
    public function setPostCode($post_code)
    {
        
        $this->post_code = $post_code;
        return $this;
    }
    
    /**
     * Gets city
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
  
    /**
     * Sets city
     * @param string $city Miejscowość
     * @return $this
     */
    public function setCity($city)
    {
        
        $this->city = $city;
        return $this;
    }
    
    /**
     * Gets street
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }
  
    /**
     * Sets street
     * @param string $street Ulica
     * @return $this
     */
    public function setStreet($street)
    {
        
        $this->street = $street;
        return $this;
    }
    
    /**
     * Gets house_no
     * @return string
     */
    public function getHouseNo()
    {
        return $this->house_no;
    }
  
    /**
     * Sets house_no
     * @param string $house_no Numer domu
     * @return $this
     */
    public function setHouseNo($house_no)
    {
        
        $this->house_no = $house_no;
        return $this;
    }
    
    /**
     * Gets flat_no
     * @return string
     */
    public function getFlatNo()
    {
        return $this->flat_no;
    }
  
    /**
     * Sets flat_no
     * @param string $flat_no Numer mieszkania
     * @return $this
     */
    public function setFlatNo($flat_no)
    {
        
        $this->flat_no = $flat_no;
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

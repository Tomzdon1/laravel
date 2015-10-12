<?php
/**
 * PERSONDATA
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
 * PERSONDATA Class Doc Comment
 *
 * @category    Class
 * @description Dane osobowe
 * @package     App\apiModels\travel\v1
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class PERSONDATA extends \App\apiModels\ApiModel implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'first_name' => 'string',
        'last_name' => 'string',
        'birth_date' => '\DateTime',
        'pesel' => 'string',
        'nationality' => 'string',
        'address' => 'App\apiModels\travel\v1\prototypes\ADDRESS'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'first_name' => 'first_name',
        'last_name' => 'last_name',
        'birth_date' => 'birth_date',
        'pesel' => 'pesel',
        'nationality' => 'nationality',
        'address' => 'address'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'first_name' => 'setFirstName',
        'last_name' => 'setLastName',
        'birth_date' => 'setBirthDate',
        'pesel' => 'setPesel',
        'nationality' => 'setNationality',
        'address' => 'setAddress'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'first_name' => 'getFirstName',
        'last_name' => 'getLastName',
        'birth_date' => 'getBirthDate',
        'pesel' => 'getPesel',
        'nationality' => 'getNationality',
        'address' => 'getAddress'
    );
  
    
    /**
      * $first_name Imię
      * @var string
      */
    protected $first_name;
    
    /**
      * $last_name Nazwisko
      * @var string
      */
    protected $last_name;
    
    /**
      * $birth_date Data urodzenia
      * @var \DateTime
      */
    protected $birth_date;
    
    /**
      * $pesel Numer PESEL
      * @var string
      */
    protected $pesel;
    
    /**
      * $nationality Obywatelstwo (kod kraju zgodny z ISO 3166-1 alpha-2)
      * @var string
      */
    protected $nationality;
    
    /**
      * $address Dane adresowe
      * @var App\apiModels\travel\v1\prototypes\ADDRESS
      */
    protected $address;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->first_name = $data["first_name"];
            $this->last_name = $data["last_name"];
            $this->birth_date = $data["birth_date"];
            $this->pesel = $data["pesel"];
            $this->nationality = $data["nationality"];
            $this->address = $data["address"];
        }
    }
    
    /**
     * Gets first_name
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }
  
    /**
     * Sets first_name
     * @param string $first_name Imię
     * @return $this
     */
    public function setFirstName($first_name)
    {
        
        $this->first_name = $first_name;
        return $this;
    }
    
    /**
     * Gets last_name
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }
  
    /**
     * Sets last_name
     * @param string $last_name Nazwisko
     * @return $this
     */
    public function setLastName($last_name)
    {
        
        $this->last_name = $last_name;
        return $this;
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
     * Gets pesel
     * @return string
     */
    public function getPesel()
    {
        return $this->pesel;
    }
  
    /**
     * Sets pesel
     * @param string $pesel Numer PESEL
     * @return $this
     */
    public function setPesel($pesel)
    {
        
        $this->pesel = $pesel;
        return $this;
    }
    
    /**
     * Gets nationality
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }
  
    /**
     * Sets nationality
     * @param string $nationality Obywatelstwo (kod kraju zgodny z ISO 3166-1 alpha-2)
     * @return $this
     */
    public function setNationality($nationality)
    {
        
        $this->nationality = $nationality;
        return $this;
    }
    
    /**
     * Gets address
     * @return App\apiModels\travel\v1\prototypes\ADDRESS
     */
    public function getAddress()
    {
        return $this->address;
    }
  
    /**
     * Sets address
     * @param App\apiModels\travel\v1\prototypes\ADDRESS $address Dane adresowe
     * @return $this
     */
    public function setAddress($address)
    {
        
        $this->address = $address;
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

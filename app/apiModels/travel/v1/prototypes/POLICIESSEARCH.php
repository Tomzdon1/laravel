<?php
/**
 * POLICIESSEARCH
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
 * POLICIESSEARCH Class Doc Comment
 *
 * @category    Class
 * @description Parametry wyszukiwania polis
 * @package     App\apiModels\travel\v1
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class POLICIESSEARCH extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'date' => '\DateTime',
        'policy_ref' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'date' => 'date',
        'policy_ref' => 'policy_ref'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'date' => 'setDate',
        'policy_ref' => 'setPolicyRef'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'date' => 'getDate',
        'policy_ref' => 'getPolicyRef'
    );
  
    
    /**
      * $date Dzień utworzenia polisy
      * @var \DateTime
      */
    public $date;
    
    /**
      * $policy_ref Identyfikator polisy
      * @var string
      */
    public $policy_ref;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->date = $data["date"];
            $this->policy_ref = $data["policy_ref"];
        }
    }
    
    /**
     * Gets date
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
  
    /**
     * Sets date
     * @param \DateTime $date Dzień utworzenia polisy
     * @return $this
     */
    public function setDate($date)
    {
        
        $this->date = $date;
        return $this;
    }
    
    /**
     * Gets policy_ref
     * @return string
     */
    public function getPolicyRef()
    {
        return $this->policy_ref;
    }
  
    /**
     * Sets policy_ref
     * @param string $policy_ref Identyfikator polisy
     * @return $this
     */
    public function setPolicyRef($policy_ref)
    {
        
        $this->policy_ref = $policy_ref;
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

<?php
/**
 * QUOTEREQUEST
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
 * QUOTEREQUEST Class Doc Comment
 *
 * @category    Class
 * @description Zestaw danych do pobrania ofert
 * @package     App\apiModels\travel\v1
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class QUOTEREQUEST extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'data' => 'App\apiModels\travel\v1\prototypes\POLICYDATA',
        'prepersons' => 'App\apiModels\travel\v1\prototypes\PREPERSON[]'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'data' => 'data',
        'prepersons' => 'prepersons'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'data' => 'setData',
        'prepersons' => 'setPrepersons'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'data' => 'getData',
        'prepersons' => 'getPrepersons'
    );
  
    
    /**
      * $data Dane do kalkulacji oferty
      * @var App\apiModels\travel\v1\prototypes\POLICYDATA
      */
    public $data;
    
    /**
      * $prepersons Wstępne informacje o ubezpieczonych
      * @var App\apiModels\travel\v1\prototypes\PREPERSON[]
      */
    public $prepersons;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->data = $data["data"];
            $this->prepersons = $data["prepersons"];
        }
    }
    
    /**
     * Gets data
     * @return App\apiModels\travel\v1\prototypes\POLICYDATA
     */
    public function getData()
    {
        return $this->data;
    }
  
    /**
     * Sets data
     * @param App\apiModels\travel\v1\prototypes\POLICYDATA $data Dane do kalkulacji oferty
     * @return $this
     */
    public function setData($data)
    {
        
        $this->data = $data;
        return $this;
    }
    
    /**
     * Gets prepersons
     * @return App\apiModels\travel\v1\prototypes\PREPERSON[]
     */
    public function getPrepersons()
    {
        return $this->prepersons;
    }
  
    /**
     * Sets prepersons
     * @param App\apiModels\travel\v1\prototypes\PREPERSON[] $prepersons Wstępne informacje o ubezpieczonych
     * @return $this
     */
    public function setPrepersons($prepersons)
    {
        
        $this->prepersons = $prepersons;
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

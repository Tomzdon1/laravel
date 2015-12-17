<?php
/**
 * IMPORTREQUEST
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
 * IMPORTREQUEST Class Doc Comment
 *
 * @category    Class
 * @description Zestaw danych do zapisania gotowej polisy
 * @package     App\apiModels\travel\v1
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class IMPORTREQUEST   extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'product_ref' => 'string',
        'sign_date' => '\DateTime',
        'data' => 'App\apiModels\travel\v1\prototypes\POLICYDATA',
        'policy_holder' => 'App\apiModels\travel\v1\prototypes\POLICYHOLDER',
        'insured' => 'App\apiModels\travel\v1\prototypes\INSURED[]'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'product_ref' => 'product_ref',
        'sign_date' => 'sign_date',
        'data' => 'data',
        'policy_holder' => 'policy_holder',
        'insured' => 'insured'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'product_ref' => 'setProductRef',
        'sign_date' => 'setSignDate',
        'data' => 'setData',
        'policy_holder' => 'setPolicyHolder',
        'insured' => 'setInsured'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'product_ref' => 'getProductRef',
        'sign_date' => 'getSignDate',
        'data' => 'getData',
        'policy_holder' => 'getPolicyHolder',
        'insured' => 'getInsured'
    );
  
    
    /**
      * $product_ref Identyfikator produktu
      * @var string
      */
    protected $product_ref;
    
    /**
      * $sign_date Data zawarcia polisy
      * @var \DateTime
      */
    protected $sign_date;
    
    /**
      * $data Dane polisy
      * @var App\apiModels\travel\v1\prototypes\POLICYDATA
      */
    protected $data;
    
    /**
      * $policy_holder Dane ubezpieczającego
      * @var App\apiModels\travel\v1\prototypes\POLICYHOLDER
      */
    protected $policy_holder;
    
    /**
      * $insured Dane ubezpieczonych
      * @var App\apiModels\travel\v1\prototypes\INSURED[]
      */
    protected $insured;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->product_ref = $data["product_ref"];
            $this->sign_date = $data["sign_date"];
            $this->data = $data["data"];
            $this->policy_holder = $data["policy_holder"];
            $this->insured = $data["insured"];
        }
    }
    
    /**
     * Gets product_ref
     * @return string
     */
    public function getProductRef()
    {
        return $this->product_ref;
    }
  
    /**
     * Sets product_ref
     * @param string $product_ref Identyfikator produktu
     * @return $this
     */
    public function setProductRef($product_ref)
    {
        
        $this->product_ref = $product_ref;
        return $this;
    }
    
    /**
     * Gets sign_date
     * @return \DateTime
     */
    public function getSignDate()
    {
        return $this->sign_date;
    }
  
    /**
     * Sets sign_date
     * @param \DateTime $sign_date Data zawarcia polisy
     * @return $this
     */
    public function setSignDate($sign_date)
    {
        
        $this->sign_date = $sign_date;
        return $this;
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
     * @param App\apiModels\travel\v1\prototypes\POLICYDATA $data Dane polisy
     * @return $this
     */
    public function setData($data)
    {
        
        $this->data = $data;
        return $this;
    }
    
    /**
     * Gets policy_holder
     * @return App\apiModels\travel\v1\prototypes\POLICYHOLDER
     */
    public function getPolicyHolder()
    {
        return $this->policy_holder;
    }
  
    /**
     * Sets policy_holder
     * @param App\apiModels\travel\v1\prototypes\POLICYHOLDER $policy_holder Dane ubezpieczającego
     * @return $this
     */
    public function setPolicyHolder($policy_holder)
    {
        
        $this->policy_holder = $policy_holder;
        return $this;
    }
    
    /**
     * Gets insured
     * @return App\apiModels\travel\v1\prototypes\INSURED[]
     */
    public function getInsured()
    {
        return $this->insured;
    }
  
    /**
     * Sets insured
     * @param App\apiModels\travel\v1\prototypes\INSURED[] $insured Dane ubezpieczonych
     * @return $this
     */
    public function setInsured($insured)
    {
        
        $this->insured = $insured;
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

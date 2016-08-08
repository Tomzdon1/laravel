<?php
/**
 * CALCULATE
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
 * CALCULATE Class Doc Comment
 *
 * @category    Class
 * @description Kalkulacja
 * @package     App\apiModels\travel\v1
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class CALCULATE extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'request' => 'App\apiModels\travel\v1\prototypes\CALCULATEREQUEST',
        'amount' => 'App\apiModels\travel\v1\prototypes\AMOUNT',
        'payment_date' => '\DateTime',
        'promo_code_valid' => 'bool'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'request' => 'request',
        'amount' => 'amount',
        'payment_date' => 'payment_date',
        'promo_code_valid' => 'promo_code_valid'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'request' => 'setRequest',
        'amount' => 'setAmount',
        'payment_date' => 'setPaymentDate',
        'promo_code_valid' => 'setPromoCodeValid'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'request' => 'getRequest',
        'amount' => 'getAmount',
        'payment_date' => 'getPaymentDate',
        'promo_code_valid' => 'getPromoCodeValid'
    );
  
    
    /**
      * $request Zapytanie, na podstawie którego obliczono amount i wartość promo_code_valid
      * @var App\apiModels\travel\v1\prototypes\CALCULATEREQUEST
      */
    public $request;
    
    /**
      * $amount Obiekt z informacją o składce
      * @var App\apiModels\travel\v1\prototypes\AMOUNT
      */
    public $amount;
    
    /**
      * $payment_date Data zapłaty
      * @var \DateTime
      */
    public $payment_date;
    
    /**
      * $promo_code_valid Czy kod promocyjny jest ważny i został uwzględniony
      * @var bool
      */
    public $promo_code_valid;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->request = $data["request"];
            $this->amount = $data["amount"];
            $this->payment_date = $data["payment_date"];
            $this->promo_code_valid = $data["promo_code_valid"];
        }
    }
    
    /**
     * Gets request
     * @return App\apiModels\travel\v1\prototypes\CALCULATEREQUEST
     */
    public function getRequest()
    {
        return $this->request;
    }
  
    /**
     * Sets request
     * @param App\apiModels\travel\v1\prototypes\CALCULATEREQUEST $request Zapytanie, na podstawie którego obliczono amount i wartość promo_code_valid
     * @return $this
     */
    public function setRequest($request)
    {
        
        $this->request = $request;
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
     * @param App\apiModels\travel\v1\prototypes\AMOUNT $amount Obiekt z informacją o składce
     * @return $this
     */
    public function setAmount($amount)
    {
        
        $this->amount = $amount;
        return $this;
    }
    
    /**
     * Gets payment_date
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->payment_date;
    }
  
    /**
     * Sets payment_date
     * @param \DateTime $payment_date Data zapłaty
     * @return $this
     */
    public function setPaymentDate($payment_date)
    {
        
        $this->payment_date = $payment_date;
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
     * @param bool $promo_code_valid Czy kod promocyjny jest ważny i został uwzględniony
     * @return $this
     */
    public function setPromoCodeValid($promo_code_valid)
    {
        
        $this->promo_code_valid = $promo_code_valid;
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

<?php
/**
 * ImportPolicyStatus
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
 * ImportPolicyStatus Class Doc Comment
 *
 * @category    Class
 * @description Opis statusu importu polisy
 * @package     App\apiModels\travel\v2
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ImportPolicyStatus extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'status' => 'string',
        'policy_id' => 'string',
        'messages' => 'object[]'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'status' => 'status',
        'policy_id' => 'policy_id',
        'messages' => 'messages'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'status' => 'setStatus',
        'policy_id' => 'setPolicyId',
        'messages' => 'setMessages'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'status' => 'getStatus',
        'policy_id' => 'getPolicyId',
        'messages' => 'getMessages'
    );
  
    
    /**
      * $status Status importu polisy
      * @var string
      */
    public $status;
    
    /**
      * $policy_id Identyfikator polisy
      * @var string
      */
    public $policy_id;
    
    /**
      * $messages Błędy importu wskazanej polisy
      * @var object[]
      */
    public $messages;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->status = $data["status"];
            $this->policy_id = $data["policy_id"];
            $this->messages = $data["messages"];
        }
    }
    
    /**
     * Gets status
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
  
    /**
     * Sets status
     * @param string $status Status importu polisy
     * @return $this
     */
    public function setStatus($status)
    {
        $allowed_values = array("OK", "WARN", "ERR");
        if (!in_array($status, $allowed_values)) {
            throw new \InvalidArgumentException("Invalid value for 'status', must be one of 'OK', 'WARN', 'ERR'");
        }
        $this->status = $status;
        return $this;
    }
    
    /**
     * Gets policy_id
     * @return string
     */
    public function getPolicyId()
    {
        return $this->policy_id;
    }
  
    /**
     * Sets policy_id
     * @param string $policy_id Identyfikator polisy
     * @return $this
     */
    public function setPolicyId($policy_id)
    {
        
        $this->policy_id = $policy_id;
        return $this;
    }
    
    /**
     * Gets messages
     * @return object[]
     */
    public function getMessages()
    {
        return $this->messages;
    }
  
    /**
     * Sets messages
     * @param object[] $messages Błędy importu wskazanej polisy
     * @return $this
     */
    public function setMessages($messages)
    {
        
        $this->messages = $messages;
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

<?php
/**
 * SmsSendRequest
 *
 * PHP version 5
 *
 * @category Class
 * @package  App\apiModels\internal\v2
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Wewnętrzne modele wymiany danych o sms
 *
 * No descripton provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: 2.0.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace App\apiModels\internal\v2\Model;

use \ArrayAccess;

/**
 * SmsSendRequest Class Doc Comment
 *
 * @category    Class */
 // @description Żądanie wysłania wiadomości SMS
/** 
 * @package     App\apiModels\internal\v2
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class SmsSendRequest implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'smsSendRequest';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = array(
        'campaign_id' => 'string',
        'message' => '\App\apiModels\internal\v2\Model\SmsSendRequestMessage[]',
        'telephone' => 'string'
    );

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = array(
        'campaign_id' => 'campaign_id',
        'message' => 'message',
        'telephone' => 'telephone'
    );

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = array(
        'campaign_id' => 'setCampaignId',
        'message' => 'setMessage',
        'telephone' => 'setTelephone'
    );

    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = array(
        'campaign_id' => 'getCampaignId',
        'message' => 'getMessage',
        'telephone' => 'getTelephone'
    );

    public static function getters()
    {
        return self::$getters;
    }

    

    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = array();

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['campaign_id'] = isset($data['campaign_id']) ? $data['campaign_id'] : null;
        $this->container['message'] = isset($data['message']) ? $data['message'] : null;
        $this->container['telephone'] = isset($data['telephone']) ? $data['telephone'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = array();
        if ($this->container['campaign_id'] === null) {
            $invalid_properties[] = "'campaign_id' can't be null";
        }
        if ($this->container['telephone'] === null) {
            $invalid_properties[] = "'telephone' can't be null";
        }
        if (!preg_match("/^\\+((48[0-9]{9})|((?!48)[0-9]{6,15}))$/", $this->container['telephone'])) {
            $invalid_properties[] = "invalid value for 'telephone', must be conform to the pattern /^\\+((48[0-9]{9})|((?!48)[0-9]{6,15}))$/.";
        }

        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properteis are valid
     */
    public function valid()
    {
        if ($this->container['campaign_id'] === null) {
            return false;
        }
        if ($this->container['telephone'] === null) {
            return false;
        }
        if (!preg_match("/^\\+((48[0-9]{9})|((?!48)[0-9]{6,15}))$/", $this->container['telephone'])) {
            return false;
        }
        return true;
    }


    /**
     * Gets campaign_id
     * @return string
     */
    public function getCampaignId()
    {
        return $this->container['campaign_id'];
    }

    /**
     * Sets campaign_id
     * @param string $campaign_id Identyfikator kampanii SMS
     * @return $this
     */
    public function setCampaignId($campaign_id)
    {
        $this->container['campaign_id'] = $campaign_id;

        return $this;
    }

    /**
     * Gets message
     * @return \App\apiModels\internal\v2\Model\SmsSendRequestMessage[]
     */
    public function getMessage()
    {
        return $this->container['message'];
    }

    /**
     * Sets message
     * @param \App\apiModels\internal\v2\Model\SmsSendRequestMessage[] $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->container['message'] = $message;

        return $this;
    }

    /**
     * Gets telephone
     * @return string
     */
    public function getTelephone()
    {
        return $this->container['telephone'];
    }

    /**
     * Sets telephone
     * @param string $telephone Numer telefonu
     * @return $this
     */
    public function setTelephone($telephone)
    {

        if (!preg_match("/^\\+((48[0-9]{9})|((?!48)[0-9]{6,15}))$/", $telephone)) {
            throw new \InvalidArgumentException('invalid value for $telephone when calling SmsSendRequest., must be conform to the pattern /^\\+((48[0-9]{9})|((?!48)[0-9]{6,15}))$/.');
        }
        $this->container['telephone'] = $telephone;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\App\apiModels\internal\v2\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\App\apiModels\internal\v2\ObjectSerializer::sanitizeForSerialization($this));
    }
}



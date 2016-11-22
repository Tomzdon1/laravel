<?php
/**
 * PolicyHolder
 *
 * PHP version 5
 *
 * @category Class
 * @package  App\apiModels\internal\v2
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Wewnętrzne modele wymiany danych o polisach
 *
 * No description provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: 2.1.0
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
 * PolicyHolder Class Doc Comment
 *
 * @category    Class */
 // @description Dane bezpieczającego
/**
 * @package     App\apiModels\internal\v2
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class PolicyHolder implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'PolicyHolder';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'data' => '\App\apiModels\internal\v2\Model\PersonData',
        'address' => '\App\apiModels\internal\v2\Model\Address',
        'email' => 'string',
        'telephone' => 'string',
        'agreements' => '\App\apiModels\internal\v2\Model\Agreement[]',
        'options' => '\App\apiModels\internal\v2\Model\OptionValue[]',
        'addons' => '\App\apiModels\internal\v2\Model\OptionValue[]'
    ];

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = [
        'data' => 'data',
        'address' => 'address',
        'email' => 'email',
        'telephone' => 'telephone',
        'agreements' => 'agreements',
        'options' => 'options',
        'addons' => 'addons'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'data' => 'setData',
        'address' => 'setAddress',
        'email' => 'setEmail',
        'telephone' => 'setTelephone',
        'agreements' => 'setAgreements',
        'options' => 'setOptions',
        'addons' => 'setAddons'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'data' => 'getData',
        'address' => 'getAddress',
        'email' => 'getEmail',
        'telephone' => 'getTelephone',
        'agreements' => 'getAgreements',
        'options' => 'getOptions',
        'addons' => 'getAddons'
    ];

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }

    

    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['data'] = isset($data['data']) ? $data['data'] : null;
        $this->container['address'] = isset($data['address']) ? $data['address'] : null;
        $this->container['email'] = isset($data['email']) ? $data['email'] : null;
        $this->container['telephone'] = isset($data['telephone']) ? $data['telephone'] : null;
        $this->container['agreements'] = isset($data['agreements']) ? $data['agreements'] : null;
        $this->container['options'] = isset($data['options']) ? $data['options'] : null;
        $this->container['addons'] = isset($data['addons']) ? $data['addons'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];
        if ($this->container['data'] === null) {
            $invalid_properties[] = "'data' can't be null";
        }
        if (!is_null($this->container['telephone']) && !preg_match("/^\\+((48[0-9]{9})|((?!48)[0-9]{6,15}))$/", $this->container['telephone'])) {
            $invalid_properties[] = "invalid value for 'telephone', must be conform to the pattern /^\\+((48[0-9]{9})|((?!48)[0-9]{6,15}))$/.";
        }

        if ($this->container['agreements'] === null) {
            $invalid_properties[] = "'agreements' can't be null";
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
        if ($this->container['data'] === null) {
            return false;
        }
        if (!preg_match("/^\\+((48[0-9]{9})|((?!48)[0-9]{6,15}))$/", $this->container['telephone'])) {
            return false;
        }
        if ($this->container['agreements'] === null) {
            return false;
        }
        return true;
    }


    /**
     * Gets data
     * @return \App\apiModels\internal\v2\Model\PersonData
     */
    public function getData()
    {
        return $this->container['data'];
    }

    /**
     * Sets data
     * @param \App\apiModels\internal\v2\Model\PersonData $data
     * @return $this
     */
    public function setData($data)
    {
        $this->container['data'] = $data;

        return $this;
    }

    /**
     * Gets address
     * @return \App\apiModels\internal\v2\Model\Address
     */
    public function getAddress()
    {
        return $this->container['address'];
    }

    /**
     * Sets address
     * @param \App\apiModels\internal\v2\Model\Address $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->container['address'] = $address;

        return $this;
    }

    /**
     * Gets email
     * @return string
     */
    public function getEmail()
    {
        return $this->container['email'];
    }

    /**
     * Sets email
     * @param string $email Adres e-mail
     * @return $this
     */
    public function setEmail($email)
    {
        $this->container['email'] = $email;

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

        if (!is_null($telephone) && (!preg_match("/^\\+((48[0-9]{9})|((?!48)[0-9]{6,15}))$/", $telephone))) {
            throw new \InvalidArgumentException("invalid value for $telephone when calling PolicyHolder., must conform to the pattern /^\\+((48[0-9]{9})|((?!48)[0-9]{6,15}))$/.");
        }

        $this->container['telephone'] = $telephone;

        return $this;
    }

    /**
     * Gets agreements
     * @return \App\apiModels\internal\v2\Model\Agreement[]
     */
    public function getAgreements()
    {
        return $this->container['agreements'];
    }

    /**
     * Sets agreements
     * @param \App\apiModels\internal\v2\Model\Agreement[] $agreements Wyrażonych/odrzucone zgodach
     * @return $this
     */
    public function setAgreements($agreements)
    {
        $this->container['agreements'] = $agreements;

        return $this;
    }

    /**
     * Gets options
     * @return \App\apiModels\internal\v2\Model\OptionValue[]
     */
    public function getOptions()
    {
        return $this->container['options'];
    }

    /**
     * Sets options
     * @param \App\apiModels\internal\v2\Model\OptionValue[] $options Wybrane opcje dodatkowe
     * @return $this
     */
    public function setOptions($options)
    {
        $this->container['options'] = $options;

        return $this;
    }

    /**
     * Gets addons
     * @return \App\apiModels\internal\v2\Model\OptionValue[]
     */
    public function getAddons()
    {
        return $this->container['addons'];
    }

    /**
     * Sets addons
     * @param \App\apiModels\internal\v2\Model\OptionValue[] $addons Dodatkowe atrybuty
     * @return $this
     */
    public function setAddons($addons)
    {
        $this->container['addons'] = $addons;

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

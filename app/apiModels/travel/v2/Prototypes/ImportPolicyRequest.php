<?php
/**
 * ImportPolicyRequest
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
 * ImportPolicyRequest Class Doc Comment
 *
 * @category    Class
 * @description Zestaw danych do zaimportowania polisy
 * @package     App\apiModels\travel\v2
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ImportPolicyRequest extends \App\apiModels\ApiModel implements ArrayAccess 
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'product_id' => 'string',
        'data' => 'App\apiModels\travel\v2\Prototypes\PolicyData',
        'payment_date' => '\DateTime',
        'policy_date' => '\DateTime',
        'policy_number' => 'string',
        'policy_holder' => 'App\apiModels\travel\v2\Prototypes\PolicyHolder',
        'insureds' => 'App\apiModels\travel\v2\Prototypes\Insured[]',
        'possessions' => 'App\apiModels\travel\v2\Prototypes\Possession[]',
        'premium' => 'App\apiModels\travel\v2\Prototypes\Premium',
        'tariff_premium' => 'App\apiModels\travel\v2\Prototypes\Premium',
        'netto_premium' => 'App\apiModels\travel\v2\Prototypes\Premium',
        'solicitors' => 'App\apiModels\travel\v2\Prototypes\Solicitor[]'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'product_id' => 'product_id',
        'data' => 'data',
        'payment_date' => 'payment_date',
        'policy_date' => 'policy_date',
        'policy_number' => 'policy_number',
        'policy_holder' => 'policy_holder',
        'insureds' => 'insureds',
        'possessions' => 'possessions',
        'premium' => 'premium',
        'tariff_premium' => 'tariff_premium',
        'netto_premium' => 'netto_premium',
        'solicitors' => 'solicitors'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'product_id' => 'setProductId',
        'data' => 'setData',
        'payment_date' => 'setPaymentDate',
        'policy_date' => 'setPolicyDate',
        'policy_number' => 'setPolicyNumber',
        'policy_holder' => 'setPolicyHolder',
        'insureds' => 'setInsureds',
        'possessions' => 'setPossessions',
        'premium' => 'setPremium',
        'tariff_premium' => 'setTariffPremium',
        'netto_premium' => 'setNettoPremium',
        'solicitors' => 'setSolicitors'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'product_id' => 'getProductId',
        'data' => 'getData',
        'payment_date' => 'getPaymentDate',
        'policy_date' => 'getPolicyDate',
        'policy_number' => 'getPolicyNumber',
        'policy_holder' => 'getPolicyHolder',
        'insureds' => 'getInsureds',
        'possessions' => 'getPossessions',
        'premium' => 'getPremium',
        'tariff_premium' => 'getTariffPremium',
        'netto_premium' => 'getNettoPremium',
        'solicitors' => 'getSolicitors'
    );
  
    
    /**
      * $product_id Identyfikator produkz
      * @var string
      */
    public $product_id;
    
    /**
      * $data 
      * @var App\apiModels\travel\v2\Prototypes\PolicyData
      */
    public $data;
    
    /**
      * $payment_date Data zapłaty
      * @var \DateTime
      */
    public $payment_date;
    
    /**
      * $policy_date Data zawarcia polisy
      * @var \DateTime
      */
    public $policy_date;
    
    /**
      * $policy_number Numer polisy
      * @var string
      */
    public $policy_number;
    
    /**
      * $policy_holder 
      * @var App\apiModels\travel\v2\Prototypes\PolicyHolder
      */
    public $policy_holder;
    
    /**
      * $insureds Dane ubezpieczonych
      * @var App\apiModels\travel\v2\Prototypes\Insured[]
      */
    public $insureds;
    
    /**
      * $possessions Mienia
      * @var App\apiModels\travel\v2\Prototypes\Possession[]
      */
    public $possessions;
    
    /**
      * $premium Składka pobrana/należna
      * @var App\apiModels\travel\v2\Prototypes\Premium
      */
    public $premium;
    
    /**
      * $tariff_premium Składka wynikająca z taryfy
      * @var App\apiModels\travel\v2\Prototypes\Premium
      */
    public $tariff_premium;
    
    /**
      * $netto_premium Składka netto
      * @var App\apiModels\travel\v2\Prototypes\Premium
      */
    public $netto_premium;
    
    /**
      * $solicitors Informacje o OWCA biorących udział w sprzedaży polisy; Wartości tego pola są weryfikowane a dokładnie uprawnienia agenta/owca do sprzedaży danego typu polisy
      * @var App\apiModels\travel\v2\Prototypes\Solicitor[]
      */
    public $solicitors;
    

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->product_id = $data["product_id"];
            $this->data = $data["data"];
            $this->payment_date = $data["payment_date"];
            $this->policy_date = $data["policy_date"];
            $this->policy_number = $data["policy_number"];
            $this->policy_holder = $data["policy_holder"];
            $this->insureds = $data["insureds"];
            $this->possessions = $data["possessions"];
            $this->premium = $data["premium"];
            $this->tariff_premium = $data["tariff_premium"];
            $this->netto_premium = $data["netto_premium"];
            $this->solicitors = $data["solicitors"];
        }
    }
    
    /**
     * Gets product_id
     * @return string
     */
    public function getProductId()
    {
        return $this->product_id;
    }
  
    /**
     * Sets product_id
     * @param string $product_id Identyfikator produkz
     * @return $this
     */
    public function setProductId($product_id)
    {
        
        $this->product_id = $product_id;
        return $this;
    }
    
    /**
     * Gets data
     * @return App\apiModels\travel\v2\Prototypes\PolicyData
     */
    public function getData()
    {
        return $this->data;
    }
  
    /**
     * Sets data
     * @param App\apiModels\travel\v2\Prototypes\PolicyData $data 
     * @return $this
     */
    public function setData($data)
    {
        
        $this->data = $data;
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
     * Gets policy_date
     * @return \DateTime
     */
    public function getPolicyDate()
    {
        return $this->policy_date;
    }
  
    /**
     * Sets policy_date
     * @param \DateTime $policy_date Data zawarcia polisy
     * @return $this
     */
    public function setPolicyDate($policy_date)
    {
        
        $this->policy_date = $policy_date;
        return $this;
    }
    
    /**
     * Gets policy_number
     * @return string
     */
    public function getPolicyNumber()
    {
        return $this->policy_number;
    }
  
    /**
     * Sets policy_number
     * @param string $policy_number Numer polisy
     * @return $this
     */
    public function setPolicyNumber($policy_number)
    {
        
        $this->policy_number = $policy_number;
        return $this;
    }
    
    /**
     * Gets policy_holder
     * @return App\apiModels\travel\v2\Prototypes\PolicyHolder
     */
    public function getPolicyHolder()
    {
        return $this->policy_holder;
    }
  
    /**
     * Sets policy_holder
     * @param App\apiModels\travel\v2\Prototypes\PolicyHolder $policy_holder 
     * @return $this
     */
    public function setPolicyHolder($policy_holder)
    {
        
        $this->policy_holder = $policy_holder;
        return $this;
    }
    
    /**
     * Gets insureds
     * @return App\apiModels\travel\v2\Prototypes\Insured[]
     */
    public function getInsureds()
    {
        return $this->insureds;
    }
  
    /**
     * Sets insureds
     * @param App\apiModels\travel\v2\Prototypes\Insured[] $insureds Dane ubezpieczonych
     * @return $this
     */
    public function setInsureds($insureds)
    {
        
        $this->insureds = $insureds;
        return $this;
    }
    
    /**
     * Gets possessions
     * @return App\apiModels\travel\v2\Prototypes\Possession[]
     */
    public function getPossessions()
    {
        return $this->possessions;
    }
  
    /**
     * Sets possessions
     * @param App\apiModels\travel\v2\Prototypes\Possession[] $possessions Mienia
     * @return $this
     */
    public function setPossessions($possessions)
    {
        
        $this->possessions = $possessions;
        return $this;
    }
    
    /**
     * Gets premium
     * @return App\apiModels\travel\v2\Prototypes\Premium
     */
    public function getPremium()
    {
        return $this->premium;
    }
  
    /**
     * Sets premium
     * @param App\apiModels\travel\v2\Prototypes\Premium $premium Składka pobrana/należna
     * @return $this
     */
    public function setPremium($premium)
    {
        
        $this->premium = $premium;
        return $this;
    }
    
    /**
     * Gets tariff_premium
     * @return App\apiModels\travel\v2\Prototypes\Premium
     */
    public function getTariffPremium()
    {
        return $this->tariff_premium;
    }
  
    /**
     * Sets tariff_premium
     * @param App\apiModels\travel\v2\Prototypes\Premium $tariff_premium Składka wynikająca z taryfy
     * @return $this
     */
    public function setTariffPremium($tariff_premium)
    {
        
        $this->tariff_premium = $tariff_premium;
        return $this;
    }
    
    /**
     * Gets netto_premium
     * @return App\apiModels\travel\v2\Prototypes\Premium
     */
    public function getNettoPremium()
    {
        return $this->netto_premium;
    }
  
    /**
     * Sets netto_premium
     * @param App\apiModels\travel\v2\Prototypes\Premium $netto_premium Składka netto
     * @return $this
     */
    public function setNettoPremium($netto_premium)
    {
        
        $this->netto_premium = $netto_premium;
        return $this;
    }
    
    /**
     * Gets solicitors
     * @return App\apiModels\travel\v2\Prototypes\Solicitor[]
     */
    public function getSolicitors()
    {
        return $this->solicitors;
    }
  
    /**
     * Sets solicitors
     * @param App\apiModels\travel\v2\Prototypes\Solicitor[] $solicitors Informacje o OWCA biorących udział w sprzedaży polisy; Wartości tego pola są weryfikowane a dokładnie uprawnienia agenta/owca do sprzedaży danego typu polisy
     * @return $this
     */
    public function setSolicitors($solicitors)
    {
        
        $this->solicitors = $solicitors;
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

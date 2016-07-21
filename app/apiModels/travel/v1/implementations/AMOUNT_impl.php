<?php
/**
 * AMOUNT
 *
 * PHP version 5
 *
 * @category    Class
 * @description
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */

namespace App\apiModels\travel\v1\implementations;

use \App\apiModels\travel\v1\prototypes\AMOUNT;

class AMOUNT_impl extends AMOUNT
{
    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'value_base_currency'   => 'currency_code',
        'value_currency'        => 'currency_code',
        'value'                 => 'value_conversion:value_base,currency_rate,2',
    ];

    /**
      * $value_base Kwota składki w walucie podstawowej
      * @var float
      */
    public $value_base;
    
    /**
      * $value_base_currency Waluta podstawowa (kod waluty zgodny z ISO 4217)
      * @var string
      */
    public $value_base_currency;
    
    /**
      * $value Kwota składki
      * @var float
      */
    public $value;
    
    /**
      * $value_currency Waluta (kod waluty zgodny z ISO 4217)
      * @var string
      */
    public $value_currency;
    
    /**
      * $currency_rate Kurs waluty
      * @var float
      */
    public $currency_rate;
    
    /**
      * $date_rate Data kursu
      * @var \DateTime
      */
    public $date_rate;
    
    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }
}

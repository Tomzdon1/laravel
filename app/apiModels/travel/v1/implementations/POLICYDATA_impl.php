<?php

/**
 * POLICYDATA
 *
 * PHP version 5
 *
 * @category    Class
 * @description 
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\POLICYDATA;

class POLICYDATA_impl extends POLICYDATA
{

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'start_date.date' => 'after_equal:today',
        'end_date.date' => 'after:start_date.date',
        'destination' => 'destination_code',
    ];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    public function setStartDate($start_date)
    {
        parent::setStartDate($start_date);
        $this->start_date->setTimezone(new \DateTimeZone('Europe/Warsaw'));
    }

    public function setEndDate($start_date)
    {
        parent::setEndDate($start_date);
        $this->end_date->setTimezone(new \DateTimeZone('Europe/Warsaw'));
    }
}

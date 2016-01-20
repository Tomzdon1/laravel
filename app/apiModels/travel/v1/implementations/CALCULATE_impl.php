<?php

/**
 * CALCULATE
 *
 * PHP version 5
 *
 * @category    Class
 * @description
 * @package     travel\v1
 * @author      Tomasz Duda <tomasz.duda@tueuropa.pl>
 */

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\CALCULATE;

class CALCULATE_impl extends CALCULATE
{
    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        //
    ];
    
    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    public function setVarCode($code)
    {
        $this->varCode = $code;
    }

    public function calculateExcelAmount($config, $excelFile, $request)
    {
//        print_r($config);

        $this->amount->setValueBaseCurrency($config['quotation']['resultCurrency']);
        $this->amount->setValueCurrency('PLN');

//        print_r($this->option_values);
        $options = array();
        if (is_array($this->option_values) || $this->option_values instanceof Traversable) {
            foreach ($this->option_values as $option) {
                if ($option->getValue() == true) {
                    $options[$option->getCode()] = true;
                }
            }
        }

        $isFamily = false;
        $birthDates = array();
        foreach ($request->getInsured() as $insured) {
            $birthDates[] = $insured->getData()->getBirthDate();
        }
        $params = [
          'DATA_OD' => $request->getData()->getStartDate(),
          'DATA_DO' => $request->getData()->getEndDate(),
          'DATA_URODZENIA' => $birthDates,
          //przekazywac true/false w bibliotece Excela mapować na T/N
          'CZY_RODZINA' => $isFamily ? 'T' : 'N',
          'ZWYZKA_ASZ' => (isset($options['TWAWS']) && $options['TWAWS']) ? 'T' : 'N',
          'ZWYZKA_ASM' => (isset($options['TWASM']) && $options['TWASM']) ? 'T' : 'N',
          'ZWYZKA_ZCP' => (isset($options['TWCHP']) && $options['TWCHP']) ? 'T' : 'N',
            // tak to moze ewentualnie wygladac przy obecnym zapisie
            // 'ZWYZKA_ASZ'  => (bool) $options['TWAWS'],
            // 'ZWYZKA_ASM'  => (bool) $options['TWASM'],
            // 'ZWYZKA_ZCP'  => (bool) $options['TWCHP'],
        ];

        $data = $excelFile->getCalculatedValues($params);
        $amountValue = 0;
        foreach ($data as $wariant) {
            if ($wariant['WARIANT'] == $this->varCode) {
                // $this->cached[$wariant['WARIANT']] = $wariant['SKLADKA'];
                // $result = $wariant['SKLADKA'];
                $amountValue = $wariant['SKLADKA'];
            }
        }
        $this->amount->setValueBase($amountValue);
        
        if ($config['quotation']['resultCurrency'] != 'PLN') {
            $recalculation = $this->recalculate2pln($amountValue, $config['quotation']['resultCurrency']);
            $AmountPLN = $recalculation['amount'];
            $this->amount->setCurrencyRate($recalculation['rate']);
            $this->amount->setDateRate($recalculation['date']);
        } else {
            $AmountPLN = $amountValue;
        }
        $this->amount->setValue($AmountPLN);

//        print_r($this->amount); //->setValueBaseCurrency('GBN');
    }

    private function recalculate2pln($amount, $amountCurrency)
    {
        $date = new \DateTime;
        $rate = 4.229;
        if ($amountCurrency == 'EUR') {
            return ['amount'=>round(($amount * $rate), 2), 'rate'=>$rate, 'date'=> $date ];
        }
    }
}

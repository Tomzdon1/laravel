<?php

/**
 * IMPORTREQUEST_impl
 *
 * PHP version 5
 *
 * @category    Class
 * @description 
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\IMPORTREQUEST;

class IMPORTREQUEST_impl extends IMPORTREQUEST
{

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'product_ref'                 => 'product_ref',
    ];

    /**
     * Valdators for model (generates warning)
     * @var array
     */
    public static $warningValidators = [
        'tariff_amount.value_base'    => 'amount_value',
        'netto_amount.value_base'     => 'amount_value',
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

    public function calculateExcelAmount($config, $excelFile)
    {
//        print_r($config);

        $this->tariff_amount->setValueBaseCurrency($config['quotation']['resultCurrency']);
        $this->tariff_amount->setValueCurrency('PLN');

//        print_r($this->option_values);
        $options = array();
        if (is_array($this->getData()->getOptionValues()) || $this->getData()->getOptionValues() instanceof Traversable) {
            foreach ($this->getData()->getOptionValues() as $option) {
                if ($option->getValue() == true) {
                    $options[$option->getCode()] = true;
                }
            }
        }

        $isFamily = false;
        $birthDates = array();
        $insuredsOptions = [];

        foreach ($this->getInsured() as $insured) {
            $birthDates[] = $insured->getData()->getBirthDate();

            if (is_array($insured->getOptionValues()) || $insured->getOptionValues() instanceof Traversable) {
                foreach ($insured->getOptionValues() as $option) {
                    if (!array_key_exists($option->getCode(), $insuredsOptions)) {
                        $insuredsOptions[$option->getCode()] = [];
                    }

                    if ($option->getValue() == true || $option->getValue() == 'T') {
                        $value = 'T';
                    } else {
                        $value = 'N';
                    }

                    $insuredsOptions[$option->getCode()][] = $value;
                }
            }
        }

        $params = [
          'DATA_OD' => $this->getData()->getStartDate(),
          'DATA_DO' => $this->getData()->getEndDate(),
          'DATA_URODZENIA' => $birthDates,
          //przekazywac true/false w bibliotece Excela mapować na T/N
          // 'CZY_RODZINA' => $isFamily ? 'T' : 'N',
          // 'ZWYZKA_ASZ' => (isset($options['TWAWS']) && $options['TWAWS']) ? 'T' : 'N',
          // 'ZWYZKA_ASM' => (isset($options['TWASM']) && $options['TWASM']) ? 'T' : 'N',
          // 'ZWYZKA_ZCP' => (isset($options['TWCHP']) && $options['TWCHP']) ? 'T' : 'N',
            // tak to moze ewentualnie wygladac przy obecnym zapisie
            // 'ZWYZKA_ASZ'  => (bool) $options['TWAWS'],
            // 'ZWYZKA_ASM'  => (bool) $options['TWASM'],
            // 'ZWYZKA_ZCP'  => (bool) $options['TWCHP'],
        ];

        $params = array_merge($params, $insuredsOptions);

        $data = $excelFile->getCalculatedValues($params);
        $amountValue = 0;
        $nettoAmountValue = 0;

        foreach ($data as $wariant) {
            if ($wariant['WARIANT'] == $this->varCode) {
                // $this->cached[$wariant['WARIANT']] = $wariant['SKLADKA'];
                // $result = $wariant['SKLADKA'];
                $amountValue = $wariant['SKLADKA'];
                $nettoAmountValue = $wariant['NETTO'];
            }
        }
        $this->tariff_amount->setValueBase($amountValue);
        $this->netto_amount->setValueBase($nettoAmountValue);
        
        if ($config['quotation']['resultCurrency'] != 'PLN') {
            $recalculation = $this->recalculate2pln($amountValue, $config['quotation']['resultCurrency']);
            $nettoRecalculation = $this->recalculate2pln($nettoAmountValue, $config['quotation']['resultCurrency']);
            $AmountPLN = $recalculation['amount'];
            $nettoAmountPLN = $nettoRecalculation['amount'];
            $this->tariff_amount->setCurrencyRate($recalculation['rate']);
            $this->tariff_amount->setDateRate($recalculation['date']);
            $this->netto_amount->setCurrencyRate($nettoRecalculation['rate']);
            $this->netto_amount->setDateRate($nettoRecalculation['date']);
        } else {
            $AmountPLN = $amountValue;
            $nettoAmountPLN = $nettoAmountValue;
        }

        $this->tariff_amount->setValue($AmountPLN);
        $this->netto_amount->setValue($nettoAmountPLN);
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

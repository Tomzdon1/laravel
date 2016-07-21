<?php

/**
 * QUOTE
 *
 * PHP version 5
 *
 * @category    Class
 * @description 
 * @package     travel\v1
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\QUOTE;

class QUOTE_impl extends QUOTE
{

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        //
    ];
    /**
     *
     * Current cached excel file path
     * @var type string
     */
    public static $staticExcelFile;
    
    /**
     * 
     * Cached offers
     * @var type mixed
     */
    public static $staticOffers;

    /**
      * $quote_ref Identyfikator oferty
      * @var string
      */
    public $quote_ref;
    
    /**
      * $amount Składka
      * @var App\apiModels\travel\v1\prototypes\AMOUNT
      */
    public $amount;
    
    /**
      * $promo_code_valid Czy kod promocyjny jest prawidłowy
      * @var bool
      */
    public $promo_code_valid;
    
    /**
      * $description Opis wariantu
      * @var string
      */
    public $description;
    
    /**
      * $details Tablica detali oferty
      * @var App\apiModels\travel\v1\prototypes\DETAIL[]
      */
    public $details;
    
    /**
      * $option_definitions Definicje atrybutów, które można użyć do kalkulacji (nie wolno zmieniać wartości atrybutów, dla których pole changable == false)
      * @var App\apiModels\travel\v1\prototypes\OPTIONDEFINITION[]
      */
    public $option_definitions;
    
    /**
      * $option_values Wartości, które zostały użyte do kalkulacji
      * @var App\apiModels\travel\v1\prototypes\OPTIONVALUE[]
      */
    public $option_values;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        print_r($data);
        parent::__construct($data);
    }

    public function setVarCode($code)
    {
        $this->varCode = $code;
    }

    // @todo
    // wszystko ponizej do przeniesienie stad
    public function recalculateAmounts($dbOffer, $quoteRequest) {
        $amounts = $this->calculateAmounts($dbOffer, $quoteRequest);
        $this->setAmount($amounts['tariff_amount']);
        // $this->netto_amount = $amounts['netto_amount'];
        // $this->tariff_amount = $amounts['tariff_amount'];
    }

    public function calculateAmounts($dbOffer, $quoteRequest) {
        $dbOffer = app('db')->collection('travel_offers')->find($dbOffer->id);
                
        if ($dbOffer) {
            $this->setVarCode($dbOffer['code']);

            if ($dbOffer['configuration']['quotation']['type'] == 'formula') {
                // Not implemented
                // return $this->calculateQuotationAmounts($dbOffer['configuration']);
                abort(Response::HTTP_NOT_IMPLEMENTED);
            } elseif ($dbOffer['configuration']['quotation']['type'] == 'excel') {
                $excelPath = env('EXCEL_DIRECTORY') . '/' . $dbOffer['configuration']['quotation']['file'];

                if ($excelPath) {
                    $excelFile = new \Tue\Calculating\calculateTravelExcel($excelPath);
                }

                if ($excelFile) {
                    return $this->calculateExcelAmounts($dbOffer['configuration'], $excelFile, $quoteRequest);
                }
            }
        }
    }

    protected function calculateExcelAmounts($config, $excelFile, $quoteRequest)
    {
        $tariff_amount = new AMOUNT_impl();
        $netto_amount = new AMOUNT_impl();
        // $tariff_amount = new self::$swaggerTypes['tariff_amount']();
        // $netto_amount = new self::$swaggerTypes['netto_amount']();

        $tariff_amount->setValueBaseCurrency($config['quotation']['resultCurrency']);
        $tariff_amount->setValueCurrency('PLN');

        $options = array();
        if (is_array($quoteRequest->getData()->getOptionValues()) || $quoteRequest->getData()->getOptionValues() instanceof Traversable) {
            foreach ($quoteRequest->getData()->getOptionValues() as $option) {
                if ($option->getValue() == true) {
                    $options[$option->getCode()] = true;
                }
            }
        }

        $isFamily = false;
        $birthDates = array();
        $insuredsOptions = [];

        foreach ($quoteRequest->getPrepersons() as $insured) {
            $birthDates[] = $insured->getBirthDate();

            if (is_array($insured->getOptionValues()) || $insured->getOptionValues() instanceof Traversable) {
                foreach ($insured->getOptionValues() as $option) {
                    if (!array_key_exists($option->getCode(), $insuredsOptions)) {
                        $insuredsOptions[$option->getCode()] = [];
                    }

                    if (in_array(strtolower($option->getValue()), [true, 'true', 't'])) {
                        $value = 'T';
                    } else if (in_array(strtolower($option->getValue()), [false, 'false', 'f'])) {
                        $value = 'N';
                    }
                    else {
                        $value = $option->getValue();
                    }

                    $insuredsOptions[$option->getCode()][] = $value;
                }
            }
        }

        $params = [
          'DATA_OD' => $quoteRequest->getData()->getStartDate(),
          'DATA_DO' => $quoteRequest->getData()->getEndDate(),
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
        $tariff_amount->setValueBase($amountValue);
        $netto_amount->setValueBase($nettoAmountValue);
        
        if ($config['quotation']['resultCurrency'] != 'PLN') {
            $recalculation = $this->recalculate2pln($amountValue, $config['quotation']['resultCurrency']);
            $nettoRecalculation = $this->recalculate2pln($nettoAmountValue, $config['quotation']['resultCurrency']);
            $AmountPLN = $recalculation['amount'];
            $nettoAmountPLN = $nettoRecalculation['amount'];
            $tariff_amount->setCurrencyRate($recalculation['rate']);
            $tariff_amount->setDateRate($recalculation['date']);
            $netto_amount->setCurrencyRate($nettoRecalculation['rate']);
            $netto_amount->setDateRate($nettoRecalculation['date']);
        } else {
            $AmountPLN = $amountValue;
            $nettoAmountPLN = $nettoAmountValue;
        }

        $tariff_amount->setValue($AmountPLN);
        $netto_amount->setValue($nettoAmountPLN);

        return ['tariff_amount' => $tariff_amount, 'netto_amount' => $netto_amount];
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

<?php

namespace App\apiModels\travel\v1\traits;

use App\apiModels\travel\v1\implementations\AMOUNTImpl;

trait AmountsCalculator {
    public function recalculateAmounts($dbOffer, $quoteRequest, $withNettoAmount = true) {
        $amounts = $this->calculateAmounts($dbOffer, $quoteRequest, $withNettoAmount);
        $this->setAmount($amounts['tariff_amount']);
        if ($withNettoAmount) {
            $this->netto_amount = $amounts['netto_amount'];
        }
        $this->tariff_amount = $amounts['tariff_amount'];
    }

    public function calculateAmounts($dbOffer, $quoteRequest, $withNettoAmount = true) {
        if ($dbOffer) {
            if ($dbOffer['configuration']['quotation']['type'] == 'formula') {
                // Not implemented
                // return $this->calculateQuotationAmounts($dbOffer['configuration']);
                abort(Response::HTTP_NOT_IMPLEMENTED);
            } elseif ($dbOffer['configuration']['quotation']['type'] == 'excel') {
                $excelPath = env('EXCEL_DIRECTORY') . '/' . $dbOffer['configuration']['quotation']['file'];
              
                if ($excelPath) {
                    return $this->calculateExcelAmounts($dbOffer['configuration'], $excelPath, $quoteRequest, $dbOffer['code'], $withNettoAmount);
                }
            }
        }
    }

    protected function calculateExcelAmounts($config, $excelPath, $quoteRequest, $varCode, $withNettoAmount)
    {
        $tariff_amount = new AMOUNTImpl();
        $netto_amount = new AMOUNTImpl();
        // $tariff_amount = new self::$swaggerTypes['tariff_amount']();
        // $netto_amount = new self::$swaggerTypes['netto_amount']();

        $tariff_amount->setValueBaseCurrency($config['quotation']['resultCurrency']);
        $tariff_amount->setValueCurrency('PLN');
        
        $data = $this->cacheOrCalculateExcel($excelPath, $quoteRequest);

        $amountValue = 0;
        $nettoAmountValue = 0;

        foreach ($data as $wariant) {
            if ($wariant['WARIANT'] == $varCode) {
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

        $amounts = ['tariff_amount' => $tariff_amount];

        if ($withNettoAmount) {
            $amounts['netto_amount'] = $netto_amount;
        }

        return $amounts;
    }

    public function getInsureds ($quoteRequest) {
      return $quoteRequest->getInsured();
    }

    private function cacheOrCalculateExcel($excelPath, $quoteRequest){
      $key = md5(json_encode($excelPath)).md5(json_encode($quoteRequest));
      
      return app('cache')->remember($key, 1, function() use ($excelPath, $quoteRequest) {
          if ($excelPath) {
            $excelFile = new \Tue\Calculating\calculateTravelExcel($excelPath);
          }

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

          foreach ($this->getInsureds ($quoteRequest) as $insured) {
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
          return $data;
        });
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
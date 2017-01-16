<?php

namespace App\apiModels\travel\v2\Traits;

use App\apiModels\travel\v2\Implementations\PremiumImpl;

trait PremiumCalculatorTrait
{

    protected $offer;
    protected $calculateRequest;
    protected $withNettoPremium = false;

    public function getInsureds($calculateRequest)
    {
        return $calculateRequest->getInsured();
    }

    public function setOffer($offer)
    {
        $this->offer = $offer;
    }

    // ta funkcja jest celowa, pomoze przy przenoszeniu funkcjonalnosci do klasy
    public function setCalculateRequest($calculateRequest)
    {
        $this->calculateRequest = $calculateRequest;
    }

    public function setWithNettoPremium($withNettoPremium)
    {
        $this->withNettoPremium = $withNettoPremium;
    }

    /**
     * Calculate premiums and set them
     */
    public function recalculatePremiums()
    {
        $premiums = $this->calculatePremiums();

        $this->setPremium($premiums['premium']);
        $this->setTariffPremium($premiums['tariff_premium']);

        if ($this->withNettoPremium) {
            $this->setNettoPremium($premiums['netto_premium']);
        }
    }

    /**
     * Calculate premiums and return them
     */
    public function calculatePremiums()
    {
        if ($this->offer) {
            if ($this->offer->configuration->quotation->type == 'formula') {
                abort(Response::HTTP_NOT_IMPLEMENTED);
                // Not implemented
                // return $this->calculateQuotationPremiums(...);
            } elseif ($this->offer->configuration->quotation->type == 'excel') {
                return $this->calculateExcelPremiums();
            }
        } else {
            throw new \Exception('Offer is not exists.');
        }
    }

    protected function calculateExcelPremiums()
    {
        $excelData = $this->cacheOrCalculateExcel();
        return $this->createPremiumsFromExcelData($excelData);
    }

    private function cacheOrCalculateExcel()
    {
        $excelPath = env('EXCEL_DIRECTORY') . '/' . $this->offer->configuration->quotation->file;
        $key = md5(json_encode($excelPath)) . md5(json_encode($this->calculateRequest));

        $calculateRequest = $this->calculateRequest;

        return app('cache')->remember($key, 1, function () use ($excelPath, $calculateRequest) {
            if ($excelPath) {
                $excelFile = new \Tue\Calculating\calculateTravelExcel($excelPath);
            }

            $options = array();
            if (is_array($calculateRequest->getData()->getOptions())
                || $calculateRequest->getData()->getOptions() instanceof Traversable
            ) {
                foreach ($calculateRequest->getData()->getOptions() as $option) {
                    if ($option->getValue() == true) {
                        $options[$option->getCode()] = true;
                    }
                }
            }

            $birthDates = array();
            $insuredsOptions = [];

            foreach ($this->getInsureds($calculateRequest) as $insured) {
                $birthDates[] = $insured->getBirthDate();

                if (is_array($insured->getOptions()) || $insured->getOptions() instanceof Traversable) {
                    foreach ($insured->getOptions() as $option) {
                        if (!array_key_exists($option->getCode(), $insuredsOptions)) {
                            $insuredsOptions[$option->getCode()] = [];
                        }

                        if (in_array(strtolower($option->getValue()), [true, 'true', 't'])) {
                            $value = 'T';
                        } elseif (in_array(strtolower($option->getValue()), [false, 'false', 'f'])) {
                            $value = 'N';
                        } else {
                            $value = $option->getValue();
                        }

                        $insuredsOptions[$option->getCode()][] = $value;
                    }
                }
            }

            $params = [
                //@ todo
                // powinno być dynamiczne mapowanie
                'DATA_OD' => $calculateRequest->getData()->getStartDate(),
                'DATA_DO' => $calculateRequest->getData()->getEndDate(),
                'DATA_URODZENIA' => $birthDates,
            ];

            $params = array_merge($params, $insuredsOptions);

            $data = $excelFile->getCalculatedValues($params);
            return $data;
        });
    }

    protected function createPremiumsFromExcelData($excelData)
    {
        $premiums = [];

        // brak osblugi kodu promocyjnego wtedy premium == tariff_premium
        $premiums['premium'] = $this->createPremiumFromExcelData('SKLADKA', $excelData);
        $premiums['tariff_premium'] = $this->createPremiumFromExcelData('SKLADKA', $excelData);

        if ($this->withNettoPremium) {
            $premiums['netto_premium'] = $this->createPremiumFromExcelData('NETTO', $excelData);
        }

        return $premiums;
    }

    protected function createPremiumFromExcelData($premiumExcelKey, $excelData)
    {
        $premiumValueBase = $this->extractPremiumValueBaseFromExcelData($premiumExcelKey, $excelData);

        $premium = new PremiumImpl();
        $premium->setValueBaseCurrency($this->offer->configuration->quotation->resultCurrency);
        $premium->setValueCurrency($this->offer->configuration->quotation->resultCurrency);

        if ($premium->getValueBaseCurrency() != $premium->getValueCurrency()) {
            abort(Response::HTTP_NOT_IMPLEMENTED);
        } else {
            $premiumValue = $premiumValueBase;
        }

        $premium->setValueBase($premiumValueBase);
        $premium->setValue($premiumValue);

        return $premium;
    }

    protected function extractPremiumValueBaseFromExcelData($premiumExcelKey, $excelData)
    {
        foreach ($excelData as $variant) {
            if ($variant['WARIANT'] == $this->offer['code']) {
                return $variant[$premiumExcelKey];
            }
        }
    }
}

<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\IMPORTREQUEST;
use App\apiModels\travel\v1\implementations\IMPORTSTATUS_impl;
use App\apiModels\travel\v1\implementations\POLICY_impl;
use App\apiModels\travel\v1\traits\AmountsCalculator;
use App\TravelOffer;
use App\Policy;

class IMPORTREQUEST_impl extends IMPORTREQUEST
{
    use AmountsCalculator;

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'product_ref'                 => 'product_ref',
        'policy_number'               => 'unique:policies',
        'policy_date.date'            => 'before_equal:data.start_date.date'
    ];

    /**
     * Valdators for model (generates warning)
     * @var array
     */
    public static $warningValidators = [
        'tariff_amount.value_base'    => 'bail|correct_calculation|amount_value',
        'netto_amount.value_base'     => 'bail|correct_calculation|amount_value',
    ];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    public function import() {
        $importStatus = new IMPORTSTATUS_impl;
        $importStatus->setQuoteRef(app('request')->attributes->get('requestId'));

        $warningsCounter = 0;
        $errosCounter = 0;

        $partnerCode = app('auth')->user()->code;
        $offer = TravelOffer::find($this->getProductRef())->where('partner', $partnerCode)->first();
        $calculatedAmounts = $this->calculateAmounts($offer, $this);

        $validator = app('validator')->make(app('request')->input()[0], self::$warningValidators, [], ['calculatedAmounts' => $calculatedAmounts]);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $property => $error) {
                $importStatus->addMessage($property, implode(', ', $error));
            }
            $status = 'WARN';
        }

        if ($errosCounter) {
            $importStatus->setStatus('ERR');
        } elseif ($warningsCounter) {
            $importStatus->setStatus('WARN');
        } else {
            $importStatus->setStatus('OK');
        }
        
        $requestedPolicy = new Policy;
        $requestedPolicy->fillFromImportRequest($this, $importStatus);
        $requestedPolicy->save();

        $importStatus->setPolicyRef($requestedPolicy->id);
        
        return $importStatus;
    }
}

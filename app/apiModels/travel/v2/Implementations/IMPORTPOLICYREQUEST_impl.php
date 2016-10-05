<?php

namespace App\apiModels\travel\v2\Implementations;

use App\apiModels\travel\v2\Prototypes\IMPORTPOLICYREQUEST;
use App\TravelOffer;
use App\Policy;
use App\apiModels\travel\v2\Traits;

class IMPORTPOLICYREQUEST_impl extends IMPORTPOLICYREQUEST
{
    use Traits\SwaggerDeserializationTrait;
    use Traits\PremiumCalculatorTrait;

    /**
     * Valdators for model
     * @var array
     */
    public static $validators = [
        'product_ref' => 'product_ref',
        'policy_number' => 'unique:policies',
        'policy_date.date' => 'before_equal:data.start_date.date'
    ];

    /**
     * Valdators for model (generates warning)
     * @var array
     */
    public static $warningValidators = [
        'tariff_amount.value_base' => 'bail|correct_calculation|amount_value',
        'netto_amount.value_base' => 'bail|correct_calculation|amount_value',
    ];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    // @todo przeniesc do kontrolera
    public function import() {
        $importPolicyStatus = new IMPORTPOLICYSTATUS_impl;

        $warningsCounter = 0;
        $errosCounter = 0;

        $partnerCode = app('auth')->user()->code;
        $this->setCalculateRequest($this);
        $this->setOffer(TravelOffer::find($this->getProductId()));
        $this->setWithNettoPremium(true);
        $calculatedPremiums = $this->calculatePremiums();

        $validator = app('validator')->make(app('request')->input()[0], self::$warningValidators, [], ['calculatedAmounts' => $calculatedPremiums]);

        $status = 'OK';
        $importPolicyStatus->setMessages([]);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $property => $error) {
                $importPolicyStatus->addMessage($property, implode(', ', $error));
            }
            $status = 'WARN';
        }
        
        $requestedPolicy = new Policy;
        // @todo mapper na policy - albo zostawic podjac decyzje
        $requestedPolicy->fillFromImportRequest($this, $importPolicyStatus);
        $requestedPolicy->save();

        $importPolicyStatus->setStatus($status);
        $importPolicyStatus->setPolicyId($requestedPolicy->id);

        return $importPolicyStatus;
    }
}

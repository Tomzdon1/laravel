<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\IMPORTREQUEST;
use App\apiModels\travel\v1\implementations\IMPORTSTATUSImpl;
use App\apiModels\travel\v1\implementations\POLICYImpl;
use App\apiModels\travel\v1\traits;
use App\apiModels\travel\v1\mappers;
use App\TravelOffer;
use App\Policy;

class IMPORTREQUESTImpl extends IMPORTREQUEST
{
    use traits\AmountsCalculator;
    use traits\SwaggerDeserializationTrait;
    
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

    public function import()
    {
        $importStatus = new IMPORTSTATUSImpl;

        $warningsCounter = 0;
        $errosCounter = 0;

        $offer = TravelOffer::find($this->getProductRef());
        $calculatedAmounts = $this->calculateAmounts($offer, $this);

        $validator = app('validator')->make(
            array_dot($this),
            self::$warningValidators,
            [],
            ['calculatedAmounts' => $calculatedAmounts]
        );

        $status = 'OK';
        $importStatus->setMessages([]);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $property => $error) {
                $importStatus->addMessage($property, implode(', ', $error));
            }
            $status = 'WARN';
        }
        
        $importStatus->setStatus($status);

        $requestedPolicy = mappers\PolicyModelMapper::fromImportRequest($this);
        $requestedPolicy->status = $importStatus->getStatus();
        $requestedPolicy->errors = $importStatus->getMessages();
        $requestedPolicy->partner = json_decode(app('auth')->user()->toJson());
        $requestedPolicy->product = json_decode(TravelOffer::find($this->getProductRef())->toJson());
        $requestedPolicy->save();
        
        $importStatus->setPolicyRef($requestedPolicy->id);

        return $importStatus;
    }
}

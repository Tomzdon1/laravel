<?php

namespace App\apiModels\travel\v1\implementations;

use App\apiModels\travel\v1\prototypes\ISSUEREQUEST;
use App\TravelOffer;
use App\apiModels\travel\v1\traits;

class ISSUEREQUESTImpl extends ISSUEREQUEST
{
    use traits\SwaggerDeserializationTrait;
    
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

    public function issue()
    {
        // Pochodzi z issuePolicyCtrl z metody issuePolicy
        // @todo wymaga dostosowania/reimplementacji
        $partnerCode = $this->partner->code;
        $data = $inputData;

        $path = $this->quote_doc['path'];
        $sourceQuote = [];

        foreach ($this->quote_doc[$path] as $query) {
            foreach ($query['response'] as $quote) {
                if ($this->quote_ref == $quote['quote_ref']) {
                    $sourceQuote = $quote;
                    break 2;
                }
            }
        }

        $calculate_path = str_replace('get_quotes', 'calculate_policy', $path);
        $policy_calculation = null;
        foreach ($this->quote_doc[$calculate_path] as $time => $record) {

            if (json_encode($inputData) == json_encode($record['response'])) {
                $policy_calculation = $this->quote_doc[$calculate_path][$time];
            }
        }

        $rate_date = new \DateTime($policy_calculation['response']['amount']['date_rate']);
        $now_date = new \DateTime();
        $interval = $now_date->diff($rate_date);
        if ($interval->days >= 7) {
            app('log')->info('rate_date: ' . print_r($rate_date, 1));
            app('log')->info('now_date: ' . print_r($now_date, 1));
            app('log')->info('difference" ' . print_r($now_date->diff($rate_date), 1));
            abort(Response::HTTP_GONE);
        }


        $product_ref = $sourceQuote['product_ref'];
        $policyM = new \App\apiModels\travel\PolicyModel($this->mongoDB);
        $policyPrint = $policyM->setPolicy($product_ref, $data, $this->partner);

        if (!$policyM->save()) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $policyId = (string) $policyM->policyId;
        $policyDate = date('Y-m-d h:i:s');

        $responseData = array();
        $responseData['policy_ref'] = $policyId;
        $responseData['policy_date'] = $policyDate;

        app('log')->info(print_r($policyPrint, 1));

        $policy = $this->objSer->deserialize($responseData, '\App\apiModels\travel\v1\prototypes\POLICY');
        $policy->setCalculate($data);

        return $this->objSer->sanitizeForSerialization($policy);
    }
}

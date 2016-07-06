<?php

namespace App\apiModels\travel\v1\Controllers;

use App\Http\Controllers\RequestCtrl;
use App\apiModels\travel\v1\implementations\IMPORTREQUEST_impl;
use App\apiModels\travel\v1\implementations\IMPORTSTATUS_impl;
use Symfony\Component\HttpFoundation\Response as Response;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;

class importPoliciesCtrl extends RequestCtrl
{

    public $partner;

    public function request(Request $request, $partner_id = null, $request_id = null, $create_new_quote_log = null)
    {
        parent::request($request, $partner_id, $request_id);

        $importStatuses = [];

        $this->objSer = new \App\apiModels\ObjectSerializer();

        foreach ($this->data as $policy) {
            $status = 'OK';
            $importStatus = new IMPORTSTATUS_impl();

            $calculatedPolicy = $this->objSer->deserialize($policy, '\App\apiModels\travel\v1\prototypes\IMPORTREQUEST');
            $calculatedPolicy->calculateAmount();

            $validator = app('validator')->make($policy, IMPORTREQUEST_impl::$warningValidators, [], ['calculatedPolicy' => $calculatedPolicy]);

            if ($validator->fails()) {
                foreach ($validator->errors()->toArray() as $property => $error) {
                    $importStatus->addMessage($property, implode(', ', $error));
                }
                $status = 'WARN';
            }

            $importStatus->setStatus($status);
            $importStatus->setPolicyRef($this->savePolicy($policy, $status, $importStatus->getMessages()));
            $importStatus->setQuoteRef($request->attributes->get('requestId'));
            $importStatus->setMessages($importStatus->getMessages());

            $importStatuses[] = $importStatus;
        }

        return $importStatuses;
    }

    /* 
    * @todo 
    * Ta funkcja powinna być w klasie POLICY i nic nie zwracać
    * Funkcja powinna być wykonywana na obiekcie i ustawiać jego pola
    */
    private function savePolicy($data, $status, $errors)
    {
        $messages = array();
        $policyId = '';

        $product_ref = $data['product_ref'];
        $policyData = [];
        $policyData['request'] = array(
            'data' => $data['data'],
            'policy_holder' => $data['policy_holder'],
            'insured' => $data['insured'],
            'policy_date' => $data['policy_date'],
            'policy_number' => $data['policy_number']
        );

        $policyData['request']['data']['destination'] = (!empty($data['data']['destination'])) ? $data['data']['destination'] : '';
        $policyData['amount'] = $data['amount'];
        
        $policyData['tariff_amount'] = $data['tariff_amount'];
        $policyData['netto_amount'] = $data['netto_amount'];
        $policyData['solicitors'] = $data['solicitors'];
        $policyData['request']['quote_ref'] = '';


        $policyM = new \App\apiModels\travel\PolicyModel();
        $policyPrint = $policyM->setPolicy($product_ref, $policyData, $this->partner, $status, $errors);

        if (!$policyM->save()) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $policyId = (string) $policyM->policyId;
        
        return $policyId;
    }
}

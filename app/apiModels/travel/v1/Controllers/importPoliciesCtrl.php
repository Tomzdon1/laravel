<?php

namespace App\apiModels\travel\v1\Controllers;

use App\Http\Controllers\Controller;
use App\apiModels\travel\v1\implementations\IMPORTREQUEST_impl;
use App\apiModels\travel\v1\implementations\IMPORTSTATUS_impl;
use Symfony\Component\HttpFoundation\Response as Response;
use Illuminate\Http\Request;

class importPoliciesCtrl extends Controller
{
    public function request(Request $request)
    {
        $importStatuses = [];

        // @todo
        // Modele powinny być deserializowane w pełni automatycznie i wstrzykiwane do kontrolera
        $objSer = new \App\apiModels\ObjectSerializer();

        foreach (json_decode($request->getContent(), true) as $policy) {
            $status = 'OK';
            $importStatus = new IMPORTSTATUS_impl();

            $calculatedPolicy = $objSer->deserialize($policy, '\App\apiModels\travel\v1\prototypes\IMPORTREQUEST');
            $calculatedPolicy->calculateAmount();

            $validator = app('validator')->make($policy, IMPORTREQUEST_impl::$warningValidators, [], ['calculatedPolicy' => $calculatedPolicy]);

            if ($validator->fails()) {
                foreach ($validator->errors()->toArray() as $property => $error) {
                    $importStatus->addMessage($property, implode(', ', $error));
                }
                $status = 'WARN';
            }

            $importStatus->setStatus($status);
            $importStatus->setPolicyRef($this->savePolicy($policy, $status, $importStatus->getMessages(), $request->user()));
            $importStatus->setQuoteRef($request->attributes->get('requestId'));
            $importStatus->setMessages($importStatus->getMessages());

            $importStatuses[] = $importStatus;
        }

        return $importStatuses;
    }

    /* 
    * @todo 
    * Ta funkcja powinna być w modelu POLICY i nic nie zwracać
    * Funkcja powinna być wykonywana na obiekcie i ustawiać jego pola
    */
    private function savePolicy($data, $status, $errors, $partner)
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
        $policyPrint = $policyM->setPolicy($product_ref, $policyData, $partner, $status, $errors);

        if (!$policyM->save()) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $policyId = (string) $policyM->policyId;
        
        return $policyId;
    }
}

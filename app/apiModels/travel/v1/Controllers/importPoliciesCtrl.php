<?php

namespace App\apiModels\travel\v1\Controllers;

use Log;
use Cache;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestCtrl;
use Illuminate\Http\Request;
use App\apiModels\travel\PolicyData;
use App\apiModels\travel\v1\implementations\IMPORTREQUEST_impl;
use Symfony\Component\HttpFoundation\Response as Response;
use Illuminate\Contracts\Validation\Validator;

class importPoliciesCtrl extends RequestCtrl
{

    public $partner;

    public function request(Request $request, $parter_id = null, $request_id = null, $create_new_quote_log = null)
    {
        parent::request($request, $parter_id, $request_id);

        $this->objSer = new \App\apiModels\ObjectSerializer();
        $this->importRequests = [];

        foreach ($this->data as $policy) {
            $errors = [];

            $this->importRequests[] = $this->objSer->deserialize($policy, '\App\apiModels\travel\v1\prototypes\IMPORTREQUEST');
            $status = 'OK';

            $validator = app('validator')->make($policy, IMPORTREQUEST_impl::$warningValidators);

            if ($validator->fails()) {
                foreach ($validator->errors()->toArray() as $property => $error) {
                    $errors[] = ['code' => $property, 'text' => implode(', ', $error)];
                }
                $this->importRequests[] = $this->objSer->deserialize($policy, '\App\apiModels\travel\v1\prototypes\IMPORTREQUEST', null, false);
                $status = 'WARN';
            }

            $this->response[] = $this->savePolicy($policy, $status, $errors);
        }

        return $this->response;
    }

    // Ta funkcja powinna być w klasie IMPORTREQUEST
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
// Mozliwe, że model polisy powinien byc spojny dla roznych typow
// Trzeba zdecydowac, czy walidacje maja się odbywac w kontrolerze, czy raczej w modelu
// mysle, ze powinny byc w policy model, w takim wypadku status i message's powinny przychodzic z modelu
// $status = $policyM->getStatus();
// $messages = $policyM->getMessages();
// w przeciwnym powinny byc w nim ustawiane
// $policyM->setStatus($status);
// $policyM->getMessages($messages);    
        // $policyCollection = $this->mongoDB->selectCollection(CP_POLICIES);
        // $policyCollection->insert($policyPrint,array('w'));
        // $policyId = (string)$policyPrint["_id"];

        if (!$policyM->save()) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $policyId = (string) $policyM->policyId;
        
        //Po wygenerowaniu modelu zawierającego IMPORT_STATUS należy refaktoryzować na model
        return ['status' => $status, 'policy_ref' => $policyId, 'messages' => $errors];
    }
}

<?php

namespace App\apiModels\travel\v1\Controllers;

//use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestCtrl;
use Illuminate\Http\Request;
use App\apiModels\travel\PolicyData;
use App\apiModels\travel\v1\prototypes\CALCULATE_impl;
use App\Events\IssuedPolicyEvent;
use Symfony\Component\HttpFoundation\Response as Response;

class issuePolicyCtrl extends RequestCtrl
{

    public $partner;
    public $excelPath;

    public function request(Request $request, $parter_id = null, $request_id = null, $create_new_quote_log = null)
    {
        parent::request($request, $parter_id, $request_id);


        if ($this->quoteLogGetValue('policyId')) {
            abort(Response::HTTP_LOCKED, 'Policy exists');
        }

        $this->objSer = new \App\apiModels\ObjectSerializer();
        $this->issue_request = $this->objSer->deserialize($this->data, '\App\apiModels\travel\v1\prototypes\CALCULATE');

        $this->response = $this->response_doc = $this->issuePolicy($this->data);

        return $this->response; //response()->json($this->response);
    }

    /**
     * Metoda Tworzy polise
     * @param array $inputData parametry wejsciowe do polisy
     * @return array Status zapytania i dane
     */
    private function issuePolicy($inputData)
    {
        $partnerCode = $this->partner->getCode();
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

        // $policyCollection = $this->mongoDB->selectCollection(CP_POLICIES);
        // $policyCollection->insert($policyPrint,array('w'));
        // $policyId = (string)$policyPrint["_id"];

        if (!$policyM->save()) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $policyId = (string) $policyM->policyId;
        $policyDate = date('Y-m-d h:i:s');

        $this->quoteLogAdd('policyId', $policyId);
        $this->quoteLogAdd('policyDate', $policyDate);

        $responseData = array();
//    $responseData['calculate'] = $data;
        $responseData['policy_ref'] = $policyId;
        $responseData['policy_date'] = $policyDate;

        app('log')->info(print_r($policyPrint, 1));

        $policy = $this->objSer->deserialize($responseData, '\App\apiModels\travel\v1\prototypes\POLICY');
        $policy->setCalculate($data);

        return $this->objSer->sanitizeForSerialization($policy);

//    $collection = $this->mongoDB->selectCollection(CP_TRAVEL_OFFERS_COL);
//    $cursor = $collection->find(array('partner'=>$partnerCode ) );
//    $cnt = $cursor->count();
//    if($cnt == 0){
//      $cursor = $collection->find(array('partner'=>OFFERS_STD_PARTNER ) );
//    }
//     $list = iterator_to_array($cursor);
//     $i = 0;
//     foreach ($list as $dbOffer){
//        if ($quote['product_ref'] == $dbOffer['_id']) {
//          $responseData = array();
//          $responseData['quote_ref'] = (string)$this->quote_doc['_id'].$i++;//
//          $this->productRefarray[]=$dbOffer['_id'];
//          $responseData['amount'] = array( );
//
//          $responseData['description']=$dbOffer['name'];
//          $responseData['details'] = $dbOffer['elements'] ;
//          
//          $responseData['option_definitions'] = $dbOffer['options'];//[['name'=>'Nazwa','description'=>'opis','code'=>'kod','value_type'=>'string','changeable'=>'true']  ];
//          $responseData['option_values'] = [['code'=>'kod','value'=>'wartosc'] ];
//
//          $responseData['promo_code_valid'] = true;
//          $responseData['request'] = $data;
//
//          $offer = $this->objSer->deserialize($responseData, '\App\apiModels\travel\v1\prototypes\CALCULATE');
//          $offer->option_values = $this->calculate_request->getData()->getOptionValues();
//          $offer->setVarCode($dbOffer['code']);
//
//          if ($dbOffer['configuration']['quotation']['type'] == 'formula')
//              $offer->calculateAmount($dbOffer['configuration']);
//          elseif ($dbOffer['configuration']['quotation']['type'] == 'excel'){
//              $excelPath = EXCEL_DIR . '/' . $dbOffer['configuration']['quotation']['file'];
//              $excelFile = $this->loadExcelFile($excelPath);
//              $offer->calculateExcelAmount($dbOffer['configuration'],$excelFile,$this->calculate_request);
//          }
//
//          return $this->objSer->sanitizeForSerialization($offer);//->toarray();
//          // return [
//            // 'request' => $data,
//            // 'promo_code_valid' => false
//          // ];
//        }
//     }

        return false;
    }

    // Funkcja do przeniesienia
    private function loadExcelFile($excelPath)
    {
        if ($this->excelPath || $this->excelPath !== $excelPath || $this->excelFile === null) {
            $this->excelPath = $excelPath;
            $this->excelFile = new \calculateTravelExcel($excelPath);
        }
        return $this->excelFile;
    }
}

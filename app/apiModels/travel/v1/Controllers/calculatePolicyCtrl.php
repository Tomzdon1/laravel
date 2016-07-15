<?php

namespace App\apiModels\travel\v1\Controllers;

use Log;
use Cache;
use Validator;
use App\Http\Controllers\RequestCtrl;
use Illuminate\Http\Request;
use App\apiModels\travel\v1\prototypes\CALCULATEREQUEST_impl;
use Tue\Calculating\calculateTravelExcel;
use Symfony\Component\HttpFoundation\Response as Response;

class calculatePolicyCtrl extends RequestCtrl
{

    public $partner;
    public $excelPath;

    public function request(Request $request)
    {
        parent::request($request, $partner_id, $request_id);

        $this->objSer = new \App\apiModels\ObjectSerializer();
        $this->calculate_request = $this->objSer->deserialize($this->data, '\App\apiModels\travel\v1\prototypes\CALCULATEREQUEST');

        $this->response = $this->response_doc = $this->calculatePolicy($this->data);

        return $this->response;
    }

    /**
     * Metoda Tworzy kalkulację
     * @param array $inputData parametry wejsciowe do kalkulacji skladki
     * @return array Status zapytania i dane
     */
    private function calculatePolicy($inputData)
    {

        $partnerCode = $this->partner->code;
        $data = $inputData;

        $path = $this->quote_doc['path'];
        $sourceQuote = [];

        foreach ($this->quote_doc[$path] as $query) {
            foreach ($query['response'] as $quote) {
                if ($this->data['quote_ref'] == $quote['quote_ref']) {
                    $sourceQuote = $quote;
                    break 2;
                }
            }
        }

        
        $list= app('db')->collection(CP_TRAVEL_OFFERS_COL)->where('partner', $partnerCode)->get();

        $cnt = count($list);
        if ($cnt == 0) {
            $list = app('db')->collection(CP_TRAVEL_OFFERS_COL)->where('partner', OFFERS_STD_PARTNER)->get();
        }
        $i = 0;

        foreach ($list as $dbOffer) {
            if ($sourceQuote['product_ref'] == $dbOffer['_id']) {
                $responseData = array();
                $responseData['quote_ref'] = (string) $this->quote_doc['_id'] . $i++;
                $this->productRefarray[] = $dbOffer['_id'];
                $responseData['amount'] = array();

                $responseData['description'] = $dbOffer['name'];
                $responseData['details'] = $dbOffer['elements'];

                $responseData['option_definitions'] = $dbOffer['options'];
                $responseData['option_values'] = [['code' => 'kod', 'value' => 'wartosc']];

                $responseData['promo_code_valid'] = true;
                $responseData['request'] = $data;

//                
                
                $offer = $this->objSer->
                    deserialize($responseData, '\App\apiModels\travel\v1\prototypes\CALCULATE');
                $offer->option_values = $this->calculate_request->getData()->getOptionValues();
                $offer->setVarCode($dbOffer['code']);
                
               

                if ($dbOffer['configuration']['quotation']['type'] == 'formula') {
                    $offer->calculateAmount($dbOffer['configuration']);
                } elseif ($dbOffer['configuration']['quotation']['type'] == 'excel') {
                    $excelPath = env('EXCEL_DIRECTORY') . '/' . $dbOffer['configuration']['quotation']['file'];
                    $excelFile = $this->loadExcelFile($excelPath);
                    $offer->calculateExcelAmount($dbOffer['configuration'], $excelFile, $this->calculate_request);
                }
//app('log')->info(print_r($offer,1)); 
                return $this->objSer->sanitizeForSerialization($offer); //->toarray();
            }
        }

       // return false;
    }

    // Funkcja do przeniesienia
    private function loadExcelFile($excelPath)
    {
        if ($this->excelPath || $this->excelPath !== $excelPath || $this->excelFile === null) {
            $this->excelPath = $excelPath;
            
            $this->excelFile = new calculateTravelExcel($excelPath);
            // Log::info('odczytalem plik');
        }
        return $this->excelFile;
    }
}

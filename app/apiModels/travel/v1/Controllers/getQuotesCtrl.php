<?php

namespace App\apiModels\travel\v1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tue\Calculating\calculateTravelExcel;

class getQuotesCtrl extends Controller
{
    public $partner;
    public $excelPath;
    public $productRefarray = array();

    public function request(Request $request)
    {
        $this->objSer = new \App\apiModels\ObjectSerializer();
        $this->quote_request = $this->objSer->
            deserialize(json_decode($request->getContent(), true), '\App\apiModels\travel\v1\prototypes\QUOTEREQUEST');

        $this->response = $this->getquotes(json_decode($request->getContent(), true));
        /**
         * Przygotowanie tablicy z odpowiedzią do zapisania w kolekcji quotes
         */
        foreach ($this->response as $num => $quote) {
            $quote['product_ref'] = $this->productRefarray[$num];
            $this->response_doc[] = $quote;
        }

        return $this->response;
    }

    /**
     * Metoda Tworzy liste ofert do przedstawienia partnerowi
     * @param array $inputData parametry wejsciowe do wyszukania ofert i kalkulacji skladki
     * @return array Status zapytania i dane
     */
    private function getquotes($inputData)
    {
        $partnerCode = app('auth')->user()->code;
        $data = app('db')->collection('travel_offers')->where('partner', $partnerCode)->get();

        $cnt = count($data);
        
        if ($cnt == 0) {
            $data= app('db')->collection('travel_offers')->where('partner', 'STD')->get();
        }
        $listToResponse = array();
        $i = 0;
        $staticExcelPath = '';
        $staticExcelFile = '';
        foreach ($data as $dbOffer) {
            $responseData = array();
            $responseData['quote_ref'] = app('request')->attributes->get('requestId') . $i++; //
            $this->productRefarray[] = $dbOffer['_id'];
            $responseData['amount'] = [];
            $responseData['description'] = $dbOffer['name'];
            $responseData['details'] = $dbOffer['elements'];

            $responseData['option_definitions'] = $dbOffer['options'];
            $responseData['option_values'] = [['code' => 'kod', 'value' => 'wartosc']];

            $offer = $this->objSer->deserialize($responseData, '\App\apiModels\travel\v1\prototypes\QUOTE');
            $offer->setOptionValues($this->quote_request->getData()->getOptionValues());
            $offer->setVarCode($dbOffer['code']);

            if ($dbOffer['configuration']['quotation']['type'] == 'formula') {
                $offer->calculateAmount($dbOffer['configuration']);
            } elseif ($dbOffer['configuration']['quotation']['type'] == 'excel') {
                $excelPath = env('EXCEL_DIRECTORY') . '/' . $dbOffer['configuration']['quotation']['file'];
                if ($excelPath != $staticExcelPath) {
                    $excelFile = $this->loadExcelFile($excelPath);
                    $staticExcelFile = $excelFile;
                } else {
                    $excelFile = $staticExcelFile;
                }
                $offer->calculateExcelAmount($dbOffer['configuration'], $excelFile, $this->quote_request);
            }

            $listToResponse[] = $this->objSer->sanitizeForSerialization($offer); //->toarray();
        }

        return $listToResponse;
    }

    private function loadExcelFile($excelPath)
    {
        if ($this->excelPath || $this->excelPath !== $excelPath || $this->excelFile === null) {
            $this->excelPath = $excelPath;
            $this->excelFile = new calculateTravelExcel($excelPath);
        }
        return $this->excelFile;
    }
}

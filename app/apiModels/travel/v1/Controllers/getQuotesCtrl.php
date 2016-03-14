<?php

namespace App\apiModels\travel\v1\Controllers;

use Log;
use Cache;
use Validator;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestCtrl;
use Illuminate\Http\Request;
use App\apiModels\travel\PolicyData;
use App\apiModels\travel\v1\prototypes\QUOTEREQUEST_impl;
use Symfony\Component\HttpFoundation\Response as Response;
use Tue\Calculating\calculateTravelExcel;

class getQuotesCtrl extends RequestCtrl
{
    public $partner;
    public $excelPath;
    public $productRefarray = array();

    public function request(Request $request, $parter_id = null, $request_id = null, $create_new_quote_log = null)
    {
        parent::request($request, $parter_id, $request_id, true);

        $this->objSer = new \App\apiModels\ObjectSerializer();
        $this->quote_request = $this->objSer->deserialize($this->data, '\App\apiModels\travel\v1\prototypes\QUOTEREQUEST');

        $this->response = $this->getquotes($this->data);
        /**
         * Przygotowanie tablicy z odpowiedzią do zapisania w kolekcji quotes
         */
        foreach ($this->response as $num => $quote) {
            $quote['product_ref'] = $this->productRefarray[$num];
            $this->response_doc[] = $quote;
        }

        $this->EndLogSave();
        return $this->response; //response()->json($this->response);
    }

    /**
     * Metoda Tworzy liste ofert do przedstawienia partnerowi
     * @param array $inputData parametry wejsciowe do wyszukania ofert i kalkulacji skladki
     * @return array Status zapytania i dane
     */
    private function getquotes($inputData)
    {
        $partnerCode = $this->partner->getCode();
        $data = $inputData;
        //$offers = new offerList($pc,$data);

        //$this->mongoManager
        
//        $users = app('db')->collection(CP_TRAVEL_OFFERS_COL)->where('partner', $partnerCode)->get();
//        \Log::info('MONGOJ'.print_r($users,1));
//         $users = app('db')->collection(CP_TRAVEL_OFFERS_COL)->where('partner', OFFERS_STD_PARTNER)->get();
//        \Log::info('MONGOJ'.print_r($users,1));
        
//        $filter = Array('partner' => $partnerCode);
//        $query = new \MongoDB\Driver\Query($filter);
//        $cursor = $this->mongoManager->executeQuery(env('MONGO_CP_DB') . '.' . CP_TRAVEL_OFFERS_COL, $query);
        
//        $collection = $this->mongoDB->selectCollection(CP_TRAVEL_OFFERS_COL);
//        $cursor = $collection->find(array('partner' => $partnerCode));
        
//        \Log::info(print_r($cursor,1));
//        $data = $cursor->toArray();
        $data = app('db')->collection(CP_TRAVEL_OFFERS_COL)->where('partner', $partnerCode)->get();

        $cnt = count($data);
        
        if ($cnt == 0) {
//            $cursor = $collection->find(array('partner' => OFFERS_STD_PARTNER));
//            $filter = Array('partner' => OFFERS_STD_PARTNER);
//            $query = new \MongoDB\Driver\Query($filter);
//            $cursor = $this->mongoManager->executeQuery(env('MONGO_CP_DB') . '.' . CP_TRAVEL_OFFERS_COL, $query);
            $data= app('db')->collection(CP_TRAVEL_OFFERS_COL)->where('partner', OFFERS_STD_PARTNER)->get();
        }
//    foreach ($cursor as $doc) {
//      $this->offers[] = $doc;
//    }
//        $list = $cursor->toArray();//iterator_to_array($cursor);
//echo '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++'."<br>\n";
        $listToResponse = array();
        $i = 0;
//        foreach ($list as $dbOffer) {
        foreach ($data as $dbOffer) {            
            $responseData = array();
            $responseData['quote_ref'] = (string) $this->quote_doc['_id'] . $i++; //
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
                $excelFile = $this->loadExcelFile($excelPath);
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
            // Log::info('odczytalem plik');
        }
        return $this->excelFile;
    }
}

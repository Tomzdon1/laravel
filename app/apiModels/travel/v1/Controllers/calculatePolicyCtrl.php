<?php

namespace App\apiModels\travel\v1\Controllers;
use Log;
use Cache;
use Validator;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestCtrl;
use Illuminate\Http\Request;
use App\apiModels\travel\PolicyData;
use App\apiModels\travel\v1\prototypes\CALCULATEREQUEST_impl;

use Symfony\Component\HttpFoundation\Response as Response;


class calculatePolicyCtrl extends RequestCtrl{
var $partner,$excelPath;
  public function request(Request $request, $parter_id = null, $request_id = null, $create_new_quote_log = null)
  {
        $this->mongoClient = new \MongoClient("mongodb://" . env('MONGO_SRV') . ":" . env('MONGO_PORT'));
        $this->mongoDB = $this->mongoClient->selectDB(env('MONGO_CP_DB'));
        if (!$parter_id) {
            $parter_id = $request->input('customer_id');
        }

        if (!$request_id) {
            $request_id = $request->input('request_id');
        }

        parent::request($request, $parter_id, $request_id);

        $this->objSer = new \App\apiModels\ObjectSerializer();
        $this->calculate_request = $this->objSer->deserialize($this->data, '\App\apiModels\travel\v1\prototypes\CALCULATEREQUEST');

        $this->response = $this->response_doc = $this->calculatePolicy($this->data);

        return $this->response; //response()->json($this->response);
    }

    /**
   * Metoda Tworzy kalkulację
   * @param Array $inputData parametry wejsciowe do kalkulacji skladki
   * @return Array Status zapytania i dane
   */
  private function calculatePolicy($inputData){
    $partnerCode = $this->partner->getCode();
    $data = $inputData;
    
    $path = $this->quote_doc['path'];
    $sourceQuote = [];
    
    foreach($this->quote_doc[$path] as $query) {
      foreach($query['response'] as $quote) {
        if ($this->data['quote_ref'] == $quote['quote_ref']) {
          $sourceQuote = $quote;
          break 2;
        }
      }    
    }

    $collection = $this->mongoDB->selectCollection(CP_TRAVEL_OFFERS_COL);
    $cursor = $collection->find(Array('partner'=>$partnerCode ) );
    $cnt = $cursor->count();
    if($cnt == 0){
      $cursor = $collection->find(Array('partner'=>OFFERS_STD_PARTNER ) );
    }
     $list = iterator_to_array($cursor);
     $i = 0;
     foreach ($list as $dbOffer){
        if ($quote['product_ref'] == $dbOffer['_id']) {
          $responseData = Array();
          $responseData['quote_ref'] = (string)$this->quote_doc['_id'].$i++;//
          $this->productRefArray[]=$dbOffer['_id'];
          $responseData['amount'] = Array( );

          $responseData['description']=$dbOffer['name'];
          $responseData['details'] = $dbOffer['elements'] ;
          
          $responseData['option_definitions'] = $dbOffer['options'];//[['name'=>'Nazwa','description'=>'opis','code'=>'kod','value_type'=>'string','changeable'=>'true']  ];
          $responseData['option_values'] = [['code'=>'kod','value'=>'wartosc'] ];

          $responseData['promo_code_valid'] = true;
          $responseData['request'] = $data;

          $offer = $this->objSer->deserialize($responseData, '\App\apiModels\travel\v1\prototypes\CALCULATE');
          $offer->option_values = $this->calculate_request->getData()->getOptionValues();
          $offer->setVarCode($dbOffer['code']);

          if ($dbOffer['configuration']['quotation']['type'] == 'formula')
              $offer->calculateAmount($dbOffer['configuration']);
          elseif ($dbOffer['configuration']['quotation']['type'] == 'excel'){
              $excelPath = EXCEL_DIR . '/' . $dbOffer['configuration']['quotation']['file'];
              $excelFile = $this->loadExcelFile($excelPath);
              $offer->calculateExcelAmount($dbOffer['configuration'],$excelFile,$this->calculate_request);
          }

          return $this->objSer->sanitizeForSerialization($offer);//->toArray();
          // return [
            // 'request' => $data,
            // 'promo_code_valid' => false
          // ];
        }
     }
     
    return false;
    
  }
  
  // Funkcja do przeniesienia
  private function loadExcelFile($excelPath)
  {
    if ($this->excelPath 
        || $this->excelPath !== $excelPath 
        || $this->excelFile === null) {
      $this->excelPath = $excelPath;
      $this->excelFile = new \calculateTravelExcel($excelPath);
      // Log::info('odczytalem plik');
    }
    return $this->excelFile;
  }
    
}

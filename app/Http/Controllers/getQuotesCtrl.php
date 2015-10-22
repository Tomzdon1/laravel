<?php

namespace App\Http\Controllers;
use Log;
use Cache;
use Validator;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestCtrl;
use Illuminate\Http\Request;
use App\apiModels\travel\PolicyData;
use App\apiModels\travel\v1\prototypes\QUOTEREQUEST_impl;

use Symfony\Component\HttpFoundation\Response as Response;


class getQuotesCtrl extends RequestCtrl{
var $partner,$excelPath;
var $productRefArray = Array();  
  public function request(Request $request, $parter_id = null, $request_id = null)
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
        $this->quote_request = $this->objSer->deserialize($this->data, '\App\apiModels\travel\v1\prototypes\QUOTEREQUEST');

        $this->response = $this->getquotes($this->data);
        /**
         * Przygotowanie tablicy z odpowiedzią do zapisania w kolekcji quotes
         */
        foreach ($this->response as $num => $quote) {
            $quote['product_ref'] = $this->productRefArray[$num];
            $this->response_doc[] = $quote;
        }
        
        return $this->response; //response()->json($this->response);
    }

    /**
   * Metoda Tworzy liste ofert do przedstawienia partnerowi
   * @param Array $inputData parametry wejsciowe do wyszukania ofert i kalkulacji skladki
   * @return Array Status zapytania i dane
   */
  private function getquotes($inputData){
    $partnerCode = $this->partner->getCode();
    $data = $inputData;
    //$offers = new offerList($pc,$data);
    
    
    
    
    
    $collection = $this->mongoDB->selectCollection(CP_TRAVEL_OFFERS_COL);
    $cursor = $collection->find(Array('partner'=>$partnerCode ) );
    $cnt = $cursor->count();
    if($cnt == 0){
      $cursor = $collection->find(Array('partner'=>OFFERS_STD_PARTNER ) );
    }
//    foreach ($cursor as $doc) {
//      $this->offers[] = $doc;
//    }
     $list = iterator_to_array($cursor);
//echo '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++'."<br>\n";
     $listToResponse = Array();
     $i = 0;
     foreach ($list as $dbOffer){
        $responseData = Array();
        $responseData['quote_ref'] = (string)$this->quote_doc['_id'].$i++;//
        $this->productRefArray[]=$dbOffer['_id'];
        $responseData['amount'] = Array( );
//          'value_base'=> 100, 
//          'value_base_currency'=>'',//$dbOffer['configuration']['quotation']['resultCurrency'],
//          'value'=> 450,
//          'value_currency'=>'PLN',
//          'currency_rate'=>4.5,
//          'date_rate'=>'2015-10-08'
//          );
        $responseData['description']=$dbOffer['name'];
        $responseData['details'] = $dbOffer['elements'] ;
        
        $responseData['option_definitions'] = $dbOffer['options'];//[['name'=>'Nazwa','description'=>'opis','code'=>'kod','value_type'=>'string','changeable'=>'true']  ];
        $responseData['option_values'] = [['code'=>'kod','value'=>'wartosc'] ];

        $offer = $this->objSer->deserialize($responseData, '\App\apiModels\travel\v1\prototypes\QUOTE');
        $offer->setOptionValues($this->quote_request->getData()->getOptionValues());
        $offer->setVarCode($dbOffer['code']);
            if ($dbOffer['configuration']['quotation']['type'] == 'formula')
                $offer->calculateAmount($dbOffer['configuration']);
            elseif ($dbOffer['configuration']['quotation']['type'] == 'excel'){
                $excelPath = EXCEL_DIR . '/' . $dbOffer['configuration']['quotation']['file'];
                $excelFile = $this->loadExcelFile($excelPath);
                $offer->calculateExcelAmount($dbOffer['configuration'],$excelFile,$this->quote_request);
            }

        

        $listToResponse[] = $this->objSer->sanitizeForSerialization($offer);//->toArray();
     }
     
 //Log:info('\App\apiModels\travel\v1\prototypes\QUOTE'.print_r($listToResponse,1));
 
    
    //uasort($listToResponse,Array($offers,'sortByAmount'));
    
    return $listToResponse;
    
  }
  
//  public static function sortByAmount($a, $b){
//    if ($a['Amount'] == $b['Amount']) {
//        return 0;
//    }
//    return ($a['Amount'] < $b['Amount']) ? -1 : 1;
//  }
  
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

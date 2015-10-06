<?php

namespace App\Http\Controllers;
use Log;
use Cache;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestCtrl;
use Illuminate\Http\Request;
use App\apiModels\travel\PolicyData;
use Symfony\Component\HttpFoundation\Response as Response;

//TODO Przeniesc do konfiguracji //
    define('MONGO_SRV','localhost');
    define('MONGO_PORT','27017');
    define('MONGO_CP_DB','Ceper');
    
    define('CP_PARTNERS_COL','partners');
    define('CP_TRAVEL_OFFERS_COL','travel_offers');
    define('OFFERS_STD_PARTNER','STD');
    define('EXCEL_DIR','./excels');
    // define('EXCEL_DIR','/mnt/ramdisk');


class getQuotesCtrl extends RequestCtrl{
var $partner;
  
  public function request(Request $request,  $parter_id, $request_id)
  {
      
    parent::request($request,  $parter_id, $request_id);
    
    
    if(empty($this->data['data']['promo_code']))
        $this->data['data']['promo_code']='';
    
    $this->PolicyData = new \App\apiModels\travel\PolicyData(
         
        $this->data['data']['start_date'], 
        $this->data['data']['end_date'], 
        $this->data['data']['abroad'], 
        $this->data['data']['family'], 
        $this->data['data']['destination'], 
        $this->data['data']['option_values'],
        $this->data['data']['promo_code']
        );
    
        \Log::info(print_r($this->PolicyData,1));
    
    $this->response = $this->getquotes($this->data);
    return $this->response; response()->json($this->response);
  }
  /**
   * Metoda Tworzy liste ofert do przedstawienia partnerowi
   * @param Array $inputData parametry wejsciowe do wyszukania ofert i kalkulacji skladki
   * @return Array Status zapytania i dane
   */
  private function getquotes($inputData){
    $pc = $this->partner->getCode();
    $data = $inputData;
    $offers = new offerList($pc,$data);
    $list = $offers->getList();
    $listToResponse = Array();
    $offer = new travelQuote($data);
    foreach ($list as $dbOffer) {
      $offer->setOffer($dbOffer);
      $listToResponse[] = $offer->getQuote();
    }
    
    //uasort($listToResponse,Array($offers,'sortByAmount'));
    return $listToResponse;
    //    return ['status'=>'OK','data'=>$listToResponse];
    // return array('status'=>'OK','data'=>$listToResponse,'dev'=>Array('partnerCode' => $this->partnerCode,'request_id' => $this->request_id));
  }
    
}

/*te klasy muszą stąd zniknąć*/

class offerList {
  public function __construct($partnerCode,$data) {
    $this->offers = Array();
    
    $this->mongoClient = new \MongoClient("mongodb://".MONGO_SRV.":".MONGO_PORT);
    $this->mongoDB = $this->mongoClient->selectDB(MONGO_CP_DB);
    
    $this->partnerCode = $partnerCode;
    
    $collection = $this->mongoDB->selectCollection(CP_TRAVEL_OFFERS_COL);
    $cursor = $collection->find(Array('partner'=>$partnerCode ) );
    $cnt = $cursor->count();
    if($cnt == 0){
      $cursor = $collection->find(Array('partner'=>OFFERS_STD_PARTNER ) );
    }
//    foreach ($cursor as $doc) {
//      $this->offers[] = $doc;
//    }
     $this->offers = iterator_to_array($cursor);
    
  }
  public function getList(){
    return $this->offers;
  }
  
  public static function sortByAmount($a, $b){
    if ($a['Amount'] == $b['Amount']) {
        return 0;
    }
    return ($a['Amount'] < $b['Amount']) ? -1 : 1;
  }
}
/**
 * Bazowa klasa dla ofert
 */
class quote{
  public $Amount;
  public $Currency = 'PLN';
  public $AmountPLN;
  public $PromoAmount;
  public $isPromoCodeValid;
//  public $Currency;
  public $Description;
  public $ProductRef;
  public $QuoteRef;
  public $optionDefinitions = [];
  public $optionValues = [];

  protected $InputData;
  protected $today;
  
  public function __construct() {
    $this->today = new \DateTime();
    $this->today->setTimezone(new \DateTimeZone('Europe/Warsaw'));
    ;
  }
}
/**
 * Klasa ofert turystycznych
 */
class travelQuote extends quote{
  private $offerDB;
  // private $Ages;
  private $persons = [];
  private $isFamily = false;
  private $options2calculation = Array();
  private $cached = Array();
  private $excelPath = null;
  private $excelFile = null;
  
  public function __construct ($data)
  { 
    parent::__construct();

    $this->InputData = $data;

    // Walidacja powinna być uruchamiana automatycznie w parent::__construct();,a  w tej klasie zdefiniowane tylko walidatory
    // $validator = Validator::make($request->all(), [
    //   'title' => 'required|unique:posts|max:255',
    //   'body' => 'required',
    // ]);

    // if ($validator->fails()) {
    //   return false;
    //   return redirect('post/create')
    //     ->withErrors($validator)
    //     ->withInput();
    // }

    $policyData =& $this->InputData['data'];
    $prepersons =& $this->InputData['prepersons'];

    // walidacje w walidatorze powyzej, tu juz sa zwalidowane dane
    // isset() zwraca false jezeli istnieje null - celowe, optymalizacja
    // if (isset($this->InputData['start_date'])) {
    //   $this->startDate = new \DateTime($policyData['start_date']);
    // }

    $this->startDate = new \DateTime($policyData['start_date']);
    $this->endDate = new \DateTime($policyData['end_date']);
    // $this->length = $this->endDate->diff($this->startDate);
    $this->isFamily = (bool) $policyData['family'];
    $this->setPersons($this->InputData['prepersons']);
  }

  public function setPersons($persons)
  {
    foreach ($persons as $num=>$person) {
      $this->persons[] = new \DateTime($person['birth_date']);
      // $birthDate = new \DateTime($person['birth_date']);
      // $age = $this->today->diff($birthDate);
      // $this->Ages[$num] = $age->y;
    }
  }

  public function setOffer($offer)
  {
    $policyData =& $this->InputData['data'];

    $this->offerDB = $offer;
    $this->Description = $offer['descrShort'];
    $this->ProductRef = (string)$this->offerDB['_id'];
    $this->optionDefinitions = $this->offerDB['options'];

    foreach ($this->optionDefinitions as $num => &$dbOption) {
      $code = $dbOption['code'];
      $key = array_search($code, array_column($policyData['option_values'], 'code'));

      $optionValue = [
        'code' => $code,
        'selected' => false,
      ];
      
      if ($dbOption['selected'] || ($key !== FALSE && $policyData['option_values'][$key]['selected'])) {
        $optionValue['selected'] = true;
        $this->options2calculation[$code] = true;
      }
      else{
        $this->options2calculation[$code] = false;
      }
      $this->optionValues[] =$optionValue;
      unset($dbOption['selected']);
    }
    
    if(!empty($this->offerDB['configuration']['quotation']['resultCurrency']))
      $this->Currency = $this->offerDB['configuration']['quotation']['resultCurrency'];

    if($offer['configuration']['quotation']['type']=='formula')
      $this->Amount = $this->calculateOffer();
    elseif($offer['configuration']['quotation']['type']=='excel')
      $this->Amount = $this->calculateExcelOffer();
    
    if($this->Currency != 'PLN')
      $this->AmountPLN = $this->recalculate2pln($this->Amount,$this->Currency);
    else
      $this->AmountPLN = $this->Amount;
  }
  

  
  
  public function getQuote(){
    return [
      'product_ref' => $this->ProductRef,
      'amount'=> [
          'value_base' => $this->AmountPLN,
          'value_base_currency' => 'PLN',
          'value' => $this->Amount,
          'value_currency' => $this->Currency,
          'currency_rate' => '4.229',
          'date_rate' =>  '2015-09-09',
      ],
      'description'=>$this->Description,
      'details'=> [],
      'option_definitions'=>$this->optionDefinitions,
      'option_values' => $this->optionValues,
    ];
  }
  
  /**
   * Metoda zwraca wysokosc skladki (w tej chwili calkowitej za wszystkie osoby)
   *
   * @return int Wysokosc skladki
   */
  private function calculateOffer(){
    // $result = 0;
    // $days = $this->length->d;
    
    // $options = $this->options2calculation;
     
    // if($this->isFamily)
    //   $persons = 'R';
    // elseif (count($this->Ages)<=2){
    //   $persons = count($this->Ages);
    //   $age = $this->Ages;
    //   eval($this->offerDB['configuration']['quotation']['calculation']);
      
    // }
    // else{
    //   $r = 0;
    //   foreach($this->Ages as $a){
    //     $persons = 1;
    //     $age = Array($a);
    //     eval($this->offerDB['configuration']['quotation']['calculation']);
    //     $r += $result;
        
    //   }
    //   $result = $r;
    // }
    // return $result;
  }

  private function loadExcelFile($excelPath)
  {
    if ($this->excelPath !== $excelPath || $this->excelFile === null) {
      $this->excelPath = $excelPath;
      $this->excelFile = new \calculateTravelExcel($excelPath);
      // Log::info('odczytalem plik');
    }
    return $this->excelFile;
  }
  
  private function calculateExcelOffer()
  {

    // $days = $this->length->d;
    $options = $this->options2calculation;
    
    // if ($this->isFamily) {
    //   $persons = 'R';
    // } elseif (count($this->Ages)<=2) {
    //   if (empty($this->cached)) {
    //     $persons = count($this->Ages);
        // $age = $this->Ages;

        // porównywanie czy wynik jest w cachu powinno odbywac sie jeszcze wczesniej, przeciez to nie dotyczy excela tylko calego zapytania
        // byc moze cachowanie moze odbywac sie poza php w samym apache (takie samo zapytanie - taki sam wynik)
        $offerHash = md5(serialize($this->InputData).serialize($this->offerDB));

        // if (Cache::store('file')->has($offerHash)) {
        //   $data = Cache::store('file')->get($offerHash);
        // }
        // else {
          $excelPath = EXCEL_DIR . '/' . $this->offerDB['configuration']['quotation']['file'];

          $excelFile = $this->loadExcelFile($excelPath);

          $params = [
            'DATA_OD'     => $this->startDate,
            'DATA_DO'     => $this->endDate,
            'DATA_URODZENIA'=> $this->persons, 

            //przekazywac true/false w bibliotece Excela mapować na T/N
            'CZY_RODZINA' => $this->isFamily ? 'T' : 'N', 
            'ZWYZKA_ASZ'  => ($options['TWAWS']) ? 'T' : 'N',
            'ZWYZKA_ASM'  => ($options['TWASM']) ? 'T' : 'N',
            'ZWYZKA_ZCP'  => ($options['TWCHP']) ? 'T' : 'N',

            // tak to moze ewentualnie wygladac przy obecnym zapisie
            // 'ZWYZKA_ASZ'  => (bool) $options['TWAWS'],
            // 'ZWYZKA_ASM'  => (bool) $options['TWASM'],
            // 'ZWYZKA_ZCP'  => (bool) $options['TWCHP'],
          ];

          // array_walk($this->Ages, function(&$item1, $key) use (&$params) {
          //   $params['WIEK'.($key+1)] = $item1;
          // });

          $data = $excelFile->getCalculatedValues($params);
          // Cache::store('file')->forever($offerHash, $data);
        // }
        

        // $params = [$days, 'E', (!$this->isFamily)?$persons:false, (!$this->isFamily)?$age[0]:false, (!empty($age[1]))?$age[1]:false, ($this->isFamily)?true:false, ($options['TWAWS'])?true:false, ($options['TWASM'])?true:false, ($options['TWCHP'])?true:false];
        // $excelFile = EXCEL_DIR.'/'.$this->offerDB['configuration']['quotation']['file'];//'SU2.xlsx';
        // $excel = new \calculateTravelExcel($excelFile, $params);
        // $data = $excel->getCalculatedValues();
        
        foreach ($data as $wariant) {
          if ($wariant['WARIANT'] == $this->offerDB['code']) {
            // $this->cached[$wariant['WARIANT']] = $wariant['SKLADKA'];
            // $result = $wariant['SKLADKA'];
            return $wariant['SKLADKA'];
          }
        }
      // }

      // $result = $this->cached[$this->offerDB['code']];
    // } else {
    //   $r = 0;
    //   $excelFile = EXCEL_DIR . '/' . $this->offerDB['configuration']['quotation']['file'];
    //   $excel = new \calculateTravelExcel($excelFile);
    //   $params = [
    //     'ILE_DNI'     => $days,
    //     'CZY_RODZINA' => $this->isFamily ? 'T' : 'N', 
    //     'ZWYZKA_ASZ'  => ($options['TWAWS']) ? true : false,
    //     'ZWYZKA_ASM'  => ($options['TWASM']) ? true : false,
    //     'ZWYZKA_ZCP'  => ($options['TWCHP']) ? true : false,
    //   ];

    //   array_walk($this->Ages, function(&$item1, $key) use (&$params) {
    //     $params['WIEK'.($key+1)] = $item1;
    //   });

    //   $data = $excel->getCalculatedValues($params);

    //   dd($data);
      
    //   foreach ($this->Ages as $a) {
    //     $persons = 1;
    //     $age = Array($a);
    //     $params = [$days, 'E', (!$this->isFamily) ? $persons : false, (!$this->isFamily) ? $age[0] : false, (!empty($age[1])) ? $age[1] : false, ($this->isFamily) ? true : false, ($options['TWAWS']) ? true : false, ($options['TWASM']) ? true : false, ($options['TWCHP']) ? true : false];
    //     $data = $excel->getCalculatedValues($params);
        
    //     foreach ($data as $wariant) {
    //       if ($wariant['WARIANT'] == $this->offerDB['code']) {
    //         $result = $wariant['SKLADKA'];
    //       }
    //     }

    //     $r += $result;
    //   }

    //   $result = $r;
    // }

    return $result;
  }
  
  private function recalculate2pln($amount,$amountCurrency){
    if($amountCurrency=='EUR')
      return round(($amount * 4.229),2);
  }
}



<?php

namespace App\Http;

/**
 * Description of Partner
 *
 * @author dalek
 */
class Partner{
  private $isAuthorized = false;
  private $partnerData =Array();
  private $name, $code, $dbId, $offerType;
  public function __construct($customerId,$type) {
    $this->offerType = $type;
    
    $this->mongoClient = new \MongoClient("mongodb://".MONGO_SRV.":".MONGO_PORT);
    $this->mongoDB = $this->mongoClient->selectDB(MONGO_CP_DB);
    
    
    if($this->partnerAuthAndConfig($customerId)){
      $this->isAuthorized = true;
      $this->name = $this->partnerData['name'];
      $this->code = $this->partnerData['code'];
      $this->offerType = $this->partnerData['offerType'];
      $this->dbId = $this->partnerData['_id'].'';
      
    }
  }
  
  public function isAuth(){
    return $this->isAuthorized;
  }
  
  public function getCode(){
    return $this->code;
  }
  
  public function partnerAuthAndConfig($customerId){
    $collection = $this->mongoDB->selectCollection(CP_PARTNERS_COL);
    $cursor = $collection->find(Array('customerId'=>$customerId,'offerType'=>Array($this->offerType=>true)));
    $cnt = $cursor->count();
    if($cnt == 0)
      return false;
      $cursor->next();// iterator_to_array($cursor);
      $itr = $cursor->current();
      $this->partnerData = $itr;
      return true;
    
  }
  
}

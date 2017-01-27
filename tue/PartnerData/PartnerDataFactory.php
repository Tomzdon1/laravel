<?php
namespace Tue\PartnerData;

class PartnerDataFactory {
    
    public static function getCRMPartnerData($wsdl_url){
        return CRMConnector::getInstance($wsdl_url);     
    }
}

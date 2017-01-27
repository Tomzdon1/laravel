<?php

namespace Tue\PartnerData;

interface Connector{
    
    /**
     * 
     * @param String $partnerCode
     * @return \Tue\PartnerData\PartnerData
     */
    public function getPartnerData($partnerCode);
}

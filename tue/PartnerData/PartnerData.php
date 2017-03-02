<?php

namespace Tue\PartnerData;

class PartnerData {

     private $_partner;

    public function __construct($result) {
        $this->_partner = json_decode($result)->partners->partner;
    }

    function getCode() {
        return strval($this->_partner->symbol);
    }

    function getName() {
        return strval($this->_partner->name);
    }

    function getDescription() {
        return strval($this->_partner->description);
    }
    
    function getStreet() {
        return strval($this->_partner->ulica_siedziba);
    }

    function getHouseNo() {
        return strval($this->_partner->nr_budynku_siedziba);
    }

    function getFlatNo() {
        return strval($this->_partner->nr_lokalu_siedziba);
    }
    
    function getPostCode() {
        return strval($this->_partner->kod_siedziba);
    }

    function getCity() {
        return strval($this->_partner->miejscowosc_siedziba);
    }

    function getCountry() {
        return strval($this->_partner->kraj_siedziba);
    }

    function getNip() {
        return strval($this->_partner->nip);
    }

    function getRegon() {
        return strval($this->_partner->regon);
    }

}
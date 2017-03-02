<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tue\Printing;

/**
 * Description of pdfPrint
 *
 * @author roznowski
 * @property \SoapClient $printout Połączenie z usługą PrintOut
 */
class pdfPrinter implements Printer {
    
    private $printout;
    
    private static $instance;
    
    /**
     * 
     * @param \SoapClient $printout
     */
    function __construct($wsdl_url) {
        // nie commitowac zakomentowanej lini, to musi byc odkomentowane
        $this->printout = new \SoapClient($wsdl_url);
    }

    
    public static function getInstance($wsdl_url) {
        if (!isset(self::$instance))
            self::$instance = new pdfPrinter($wsdl_url);
        
        return self::$instance;
    }
    
    /**
     * Funkcja wysyła żądanie do PrintOut dla danych w XML 
     * 
     * @param String $template_name
     * @param String $data
     * @return \Tue\Printing\PrintResult
     * @throws \Tue\Printing\SoapFault
     */
    public function getDocument($template_name, $data) {
        try {
            $result = $this->printout->StartSingleFileProcess([
                'templateid'=>$template_name,
                'xml'=>$data,
                'format'=>'xml'
            ]);
            
            return 
                new PrintResult($result->isError ? null : $result->file,
                                $result->isError,
                                $result->errorMsg,
                                FileType::PDF);
                        
        } catch (SoapFault $fault) {
            throw $fault;
        }         
    }

    /**
     * Funkcja wysyła żądanie do PrintOut dla danych w JSON 
     *
     * @param String $template_name
     * @param String $json
     * @return \Tue\Printing\PrintResult
     * @throws \Tue\Printing\SoapFault
     */
    public function getDocumentFromJSON($template_name, $json) {
        return $this->getDocumentFromArray($template_name, json_decode($json, true));
    }

    /**
     * Funkcja wysyła żądanie do PrintOut dla danych w postaci tablicy
     * 
     * @param String $template_name
     * @param Array $array
     * @return \Tue\Printing\PrintResult
     * @throws \Tue\Printing\SoapFault
     */
    public function getDocumentFromArray($template_name, $array) {
        $xml = $this->arrayToPrintOutXML($array);
        return $this->getDocument($template_name, $xml);
    }

    /**
     * Funkcja konwertuje tablicę (zdeserializowany JSON np. polisę w standardzie CP) na XML dla PrintOut
     * 
     * @param Array $array
     * @return DOMDocument XML dla PrintOut
     */
    private function arrayToPrintOutXML($array) {
        $xml = new \DOMDocument();
        $xml->loadXML('<?xml version="1.0" encoding="UTF-8"?><Requests xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="Requests.xsd"><Request><listOfData><Data/></listOfData></Request></Requests>');
        $dataFields = $xml->importNode($this->arrayToXMLDataFields($array), true);
        $xml->getElementsByTagName('Data')->item(0)->appendChild($dataFields);
        // app('log')->info($xml->saveXML());
        return $xml->saveXML();
    }

    /**
     * Funkcja tworzy rekurencyjnie atrybut XML DataFields z dostarczonej tablicy
     * 
     * @param Array $array
     * @param string $path
     * @param boolean $parentArrayAssoc
     * @return DOMElement $xml XML dla PrintOut
     */
    private function arrayToXMLDataFields($array, $path = null, $parentArrayAssoc = false) {
        $xml = new \DOMDocument();
        $arrayAssoc = $this->is_assoc($array);

        // Jeżeli array to nie obiekt (tablica obiektów) lub jego rodzic jest obiektem, to utwórz Container (kontener dla obiektów)
        if (!$arrayAssoc || $parentArrayAssoc) {
            $root = $xml->createElement('Container');
            $root->setAttribute('name', strtoupper($path));
            $root->setAttribute('subtemplate', strtoupper($path));
            $root->setAttribute('type', 'template');
            $xml->appendChild($root);
        }
        else {
            $root = $xml;
        }

        // Jeżeli array to obiekt to dla każdego obiektu tworzymy DataFields (Obiekt)
        if ($arrayAssoc) {
            $dataFields = $xml->createElement('DataFields');
            $root->appendChild($dataFields);
            $root = $dataFields;
        }

        foreach ($array as $key => $element) {
            if (is_array($element)) {
                $childDataFields = $xml->importNode($this->arrayToXMLDataFields($element, ($path ? ($arrayAssoc ? $path.'_'.$key : $path) : $key), $arrayAssoc), true);
                $root->appendChild($childDataFields);
            }
            else {
                $child = $xml->createElement('Field');
                // Typ pola ustawiony zawsze na string
                // $child->setAttribute('type', gettype($element));
                $child->setAttribute('type', 'string');
                $child->setAttribute('name', strtoupper($key));
                $child->setAttribute('value', $this->formatDate($element, $key));
                $root->appendChild($child);
            }
        }
        return $xml->documentElement;
    }

    /**
     * Funkcja sprawdza czy tablica jest asocjacyjna, jeżeli tak zwraca true
     * 
     * @param Array $array
     * @return boolean
     */
    private function is_assoc(array $array) {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }

    /**
     * Funkcja formatuje argument jako datę, jeżeli pole jest datą
     * 
     * @param Array $array
     * @return boolean
     */
    private function formatDate($value, $name) {
        if (($d = \DateTime::createFromFormat(\DateTime::ATOM, $value)) || ($d = \DateTime::createFromFormat('Y-m-d', $value))) {
            return $name == 'DateTime' ? $d->format('d-m-Y') : $d->format('d-m-Y');
        }

        return $value;
    }

}

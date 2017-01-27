<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tue\Printing;

/**
 * Description of PrinterFactory
 *
 * @author roznowski
 */
class PrinterFactory {
    
    /**
     * 
     * @param String $wsdl_url
     * @return Printer
     */
    public  static function getPdfPrinter($wsdl_url){
        return pdfPrinter::getInstance($wsdl_url);     
    }
    
    public  static function getPdfPolicyPrinter($wsdl_url){
        return pdfPolicyPrinter::getInstance($wsdl_url);     
    }
}

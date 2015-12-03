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
        $this->printout = new \SoapClient($wsdl_url);
    }

    
    public static function getInstance($wsdl_url) {
        if (!isset(self::$instance))
            self::$instance = new pdfPrinter($wsdl_url);
        
        return self::$instance;
    }
    
    /**
     * 
     * @param String $template_name
     * @param String $data
     * @return \Tue\Printing\PrintResult
     * @throws \Tue\Printing\SoapFault
     */
    public function getDocument($template_name, $data) {
        try {
            $result = $this->printout->StartSingleFileProcess(
                        array(
                            'templateid'=>$template_name,
                            'xml'=>$data,
                            'format'=>'xml',                                    
                        )
            );
            
            return 
                new PrintResult($result->isError ? null : $result->file   ,
                                $result->isError,
                                $result->errorMsg,
                                FileType::PDF
                                 );
                        
        } catch (SoapFault $fault) {
            throw $fault ;          
        }         
    }

}

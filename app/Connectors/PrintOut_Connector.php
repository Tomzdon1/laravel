<?php

namespace App\Connectors;

use PrintOut\PrintOutService;
use PrintOut\PrintSingleFileResult;

/**
 * Description of PrintOut_connector
 * Class used to executing generating PDF from template
 * use: PrintOut_connector::getInstance()->PrintSingleFile 
 * @author roznowski
 *  
 */
class PrintOut_connector  {
        
   
   private $printoutservice;
   
   public function __construct() {
       \Log::debug("WSDL=".env('PRINTOUT_WSDL'));
       $this->printoutservice = new PrintOutService(env('PRINTOUT_WSDL'));
       
              
   }
   
    /**
     * 
     * @param type $template_name 
     * @param type $content_xml
     * @return PrintSingleFileResult pdfContent
     */      
    public function PrintSingleFile($template_name,$content_xml){
        return $this->printoutservice->PrintPdf($template_name, $content_xml);
    }
   
}

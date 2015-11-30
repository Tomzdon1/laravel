<?php

namespace App\Connectors;



/**
 * Description of PrintOut_connector
 * Class used to executing generating PDF from template
 * use: PrintOut_connector::getInstance()->PrintSingleFile 
 * @author roznowski
 *  
 */
class PrintOut_connector {
        
   
    /** @var \SoapClient SOAP Connection to Printut */
   private $soapconn;
    
    
   public function __construct() {
       \Log::debug("WSDL=".env('PRINTOUT_WSDL'));
        $this->soapconn = 
            new \SoapClient (
                    env('PRINTOUT_WSDL')
                    );               
    }
    
    
    /**
     * 
     * @param type $template_name 
     * @param type $content_xml
     * @return type $String pdfContent
     */
    public function PrintSingleFile( $template_name,
                                     $content_xml
                                    )     
    {
        try {
            $result = $this->soapconn->StartSingleFileProcess(
                        array(
                            'templateid'=>$template_name,
                            'xml'=>$content_xml,
                            'format'=>'xml',                                    
                        )
            );
            
            if (isset($result->file))
            {
                return $result->file;                    
            }
            else {
                throw new Exception();
            }
            
            
        } catch (SoapFault $fault) {
            throw $fault ;          
        }                
                
    }
}

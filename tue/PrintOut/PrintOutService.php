<?php

namespace PrintOut;

/**
 * Description of PrintOut_connector
 * Class used to executing generating PDF from template
 * use: PrintOut_connector::getInstance()->PrintSingleFile 
 * @author roznowski
 *  
 */
class PrintOutService {

    
   
    /** @var \SoapClient SOAP Connection to Printut */
   private $soapconn;
    
    
   public function __construct($wsdl_url) {       
        $this->soapconn = 
            new \SoapClient (
                    $wsdl_url
                    );               
    }
    
    
    /**
     * 
     * @param type $template_name 
     * @param type $content_xml
     * @return type PrintSingleFileResult pdfContent
     */
    public function PrintPdf( $template_name,
                            $content_xml,
                            $type = FileType::PDF
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
            
            return 
                new PrintSingleFileResult($result->isError ? null : $result->file   ,
                                          $result->isError,
                                          $result->errorMsg,
                                          $type
                                         );
                        
        } catch (SoapFault $fault) {
            throw $fault ;          
        }                
                
    }
}

<?php

namespace Tue\Printing;

use App\Policy;

class pdfPolicyPrinter extends pdfPrinter {
    
    private static $instance;
    
    public static function getInstance($wsdl_url) {
        if (!isset(self::$instance))
            self::$instance = new pdfPolicyPrinter($wsdl_url);
        
        return self::$instance;
    }
    
    /**
     * Funkcja wysyła żądanie do PrintOut dla danej polisy 
     * 
     * @param String $template_name
     * @param Policy $policz
     * @return \Tue\Printing\PrintResult
     * @throws \Tue\Printing\SoapFault
     */
    public function getDocumentFromPolicy($template_name, Policy $policy)
    {
        $array = PolicyIssueRequestMapper::fromModel($policy);
        return $this->getDocumentFromArray($template_name, $array);
    }
}

<?php

namespace Tue\Printing;

/**
 *
 * @author roznowski
 */
interface Printer{
    
    /**
     * 
     * @param String $template_name
     * @param String $data
     * @return \Tue\Printing\PrintResult
     */
    public function getDocument($template_name, $data);
}

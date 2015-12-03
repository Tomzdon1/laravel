<?php

namespace PrintOut;

/**
 * Description of PdfPrintingResult
 *
 * @author roznowski
 */
class PrintSingleFileResult {
    
    private $_file;
    private $_isError;
    private $_errorMsg;
    private $_content_type;
    
    public function __construct($file,$isError,$errorMsg,$contentType) {
        $this->_file = $file;
        $this->_isError = $isError;
        $this->_errorMsg = $errorMsg;
        $this->_content_type = $contentType;
    }
    
    function File() {
        return $this->_file;
    }

    function IsError() {
        return $this->_isError;
    }

    function ErrorMsg() {
        return $this->_errorMsg;
    }

    function ContentType() {
        return $this->_content_type;
    }
    
}

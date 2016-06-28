<?php

namespace App\Connectors;

class ESB_connector 
{
    public function show()
    {
        return 'I\'am ESB connector';
    }
    
    public function doTestRequest()
    {
        $sslParams = array('verify_peer' => false,'allow_self_signed' => true);
        $this->context = stream_context_create(array('ssl' => $sslParams));
        $this->queryType = 'NONLIFE';
        $requestString = json_encode(Array('searchStr' => ''));
        $serviceName = 'COLLAB.getTrkoList';
        
        $this->client = new \SoapClient("https://192.168.7.50/esbExt/tuservice?wsdl", array("trace" => 8, "exception" => 1, 'stream_context' => $this->context));
        
        $result = $this->client->invoke(
              array("turequest" =>
                  array(
                      'content' => $requestString,
                      'contentType' => 'BINARY',
                      'customerId' => 'COLLAB',
                      'queryType' => $this->queryType,
                      'serviceName' => $serviceName,
                      'requestTimeout' => 5000
                  )
              )
      );

      $this->result = $result;
      return $this->result;
    }
}

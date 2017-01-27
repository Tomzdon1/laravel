<?php

namespace Tue\PartnerData;

use Exception;

class CRMConnector implements Connector {
    
    private $url;
    private $connector;
    
    private static $instance;
    
    /**
     * 
     * @param string $url
     */
    function __construct($url) {
        $this->url = $url;
    }

    
    public static function getInstance($url) {
        if (!isset(self::$instance))
            self::$instance = new CRMConnector($url);
        
        return self::$instance;
    }
    
    /**
     * 
     * @param String $partnerCode
     * @return \Tue\PartnerData\PartnerData
     */
    public function getPartnerData($partnerCode) {
        $result = false;

        try {
            $this->connect();

            curl_setopt($this->connector, CURLOPT_URL, $this->url . $partnerCode);
            curl_setopt($this->connector, CURLOPT_HEADER, 0);
            curl_setopt($this->connector, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($this->connector);

            $this->closeConnection();
        } catch (Exception $e) {
            throw $e;
        }
        if ($result != false) {
            return json_decode($result)->partners->partner;
        } else {
            dd(curl_error($this->connector));
            throw new Exception('Error when getting partner data.');
        }
    }


    protected function connect() {
        $this->connector = curl_init();
    }

    protected function closeConnection() {
        curl_close($this->connector);
    }

}

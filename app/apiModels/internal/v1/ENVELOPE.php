<?php
/**
 * ENVELOPE
 *
 * PHP version 5
 *
 * @category    Class
 * @description Klasa opakowujaca wiadomosci w komunikacji wewnetrznej
 * @package     Europa\internal
 * @author      Krzysztof Dałek <krzysztof.dalek@tueuropa.pl>
 */

namespace App\apiModels\internal\v1;

class ENVELOPE
{

    protected $body;
    protected $sendDT;
    protected $type;
    protected $company;
    protected $src_id;
    protected $dst_id;

    
    public function __construct()
    {
        $this->sendDT = new \Date();
    }
    
    public function encode()
    {
        $env = array();
        $env['type'] = $this->type;
        $env['body'] = $this->body;
        $env['sendDT'] = $this->sendDT;
        $env['company'] = $this->company;
        $env['src_id'] = $this->src_id;
        $env['dst_id'] = $this->dst_id;
        
        return json_encode($env, JSON_FORCE_OBJECT);
    }
    
    public function decode($json)
    {
        try {
            $env = json_decode($json, true);
        } catch (Exception $e) {
            return false;
        }
        if (empty($env['type']) || empty($env['sendDT']) || empty($env['body'])) {
            return false;
        }
        
        $this->type     = $env['type'];
        $this->body     = $env['body'];
        $this->sendDT   = $env['sendDT'];
        if (!empty($env['company'])) {
            $this->company  = $env['company'];
        }
        if (!empty($env['src_id'])) {
            $this->src_id   = $env['src_id'];
        }
        
        if (!empty($env['dst_id'])) {
            $this->dst_id   = $env['dst_id'];
        }
        return true;
    }
    

    public function getBody()
    {
        return $this->body;
    }

    public function getSendDT()
    {
        return $this->sendDT;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getSrcId()
    {
        return $this->src_id;
    }

    public function getDstId()
    {
        return $this->dst_id;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setSendDT($sendDT)
    {
        $this->sendDT = new \Date();
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }

    public function setSrcId($src_id)
    {
        $this->src_id = $src_id;
    }

    public function setDstId($dst_id)
    {
        $this->dst_id = $dst_id;
    }
}

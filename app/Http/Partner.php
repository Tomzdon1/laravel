<?php

namespace App\Http;

/**
 * Description of Partner
 *
 * @author dalek
 */
class Partner
{

    private $isAuthorized = false;
    public $partnerData = array();
    public $name;
    public $code;
    public $dbId;
    public $offerType;
    public $customerId;

    public function __construct($customerId, $type)
    {
        $this->offerType = $type;

        if ($this->partnerAuthAndConfig($customerId)) {
            $this->isAuthorized = true;
            $this->name = $this->partnerData['name'];
            $this->code = $this->partnerData['code'];
            $this->offerType = $this->partnerData['offerType'];
            $this->dbId = $this->partnerData['_id'] . '';
            $this->customerId = $customerId;
        }
    }

    public function isAuth()
    {
        return $this->isAuthorized;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getPartnerData()
    {
        return $this->partnerData;
    }

    public function partnerAuthAndConfig($customerId)
    {

        $data = app('db')->collection(CP_PARTNERS_COL)->
                where('customerId', $customerId)->where('offerType.' . $this->offerType, true)->get();

        $cnt = count($data);
        if ($cnt == 0) {
            return false;
        }
        $this->partnerData = array();
        $this->partnerData['name'] = $data[0]['name'];
        $this->partnerData['code'] = $data[0]['code'];
        $this->partnerData['offerType'] = $data[0]['offerType'];
        $this->partnerData['_id'] = $data[0]['_id'];
        $this->partnerData['customerId'] = $customerId;
        $this->partnerData['apis'] = $data[0]['apis'];
        return true;
    }

    public function getStdPartnerData()
    {
        $collection = $this->mongoDB->selectCollection(CP_PARTNERS_COL);
        return $collection->findOne(['code' => 'STD']);
    }
}

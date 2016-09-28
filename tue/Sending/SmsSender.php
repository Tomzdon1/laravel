<?php

namespace Tue\Sending;

use App\apiModels\internal\v2 as internal;

class SmsSender extends SenderQueueAbstract implements SenderInterface  {
   
    const TYPE = 'sms-send-request';
    const VERSION = '2.0.0';
    const QUEUE_EXCHANGE = 'sms';
    const QUEUE_ROUTING_KEY = 'sms';

    private $smsSendRequest;

    function __construct() {
        parent::__construct();

        $this->setBody(new internal\Model\SmsSendRequest());
    }
}

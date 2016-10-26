<?php

namespace Tue\Sending;

use App\apiModels\internal\v2 as internal;

class MailSender extends SenderQueueAbstract {
   
    const TYPE = 'mail-send-request';
    const VERSION = '2.0.0';
    const QUEUE_EXCHANGE = 'email';
    const QUEUE_ROUTING_KEY = '';

    private $mailSendRequest;

    function __construct() {
        parent::__construct();

        $this->setBody(new internal\Model\MailSendRequest());
    }
}

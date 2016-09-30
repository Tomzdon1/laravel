<?php

namespace Tue\Sending;

use App\apiModels\internal\v2 as internal;

class PolicySender extends SenderQueueAbstract {
   
    const TYPE = 'policy-issue-request';
    const VERSION = '2.0.0';
    const QUEUE_EXCHANGE = 'cp.out.all';
    const QUEUE_ROUTING_KEY = 'cp.out.all';

    private $policyIssueRequest;

    function __construct() {
        parent::__construct();

        $this->setBody(new internal\Model\PolicyIssueRequest());
    }
}

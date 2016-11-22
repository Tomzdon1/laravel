<?php

namespace Tue\Sending;

use App\apiModels\internal\v2 as internal;
use App\Policy;

class PolicySender extends SenderQueueAbstract {
   
    const TYPE = 'policy-issue-request';
    const VERSION = '2.1.0';
    const QUEUE_EXCHANGE = 'cp.out.all';
    const QUEUE_ROUTING_KEY = 'cp.out.all';

    private $policyIssueRequest;

    function __construct() {
        parent::__construct();

        $this->setBody(new internal\Model\PolicyIssueRequest());
    }
    
    public function setPolicy(Policy $policy) {
        internal\Mappers\PolicyIssueRequestMapper::fromModel($policy, $this->getBody());
    }
}

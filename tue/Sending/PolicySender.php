<?php

namespace Tue\Sending;

use App\apiModels\internal\v2 as internal;

class PolicySender extends SenderQueueAbstract implements SenderInterface  {
   
    const TYPE = 'policy-issue-request';
    const VERSION = '2.0.0';

    private $policyIssueRequest;

    function __construct() {
        parent::__construct();

        $this->setBody(new internal\Model\PolicyIssueRequest());
    }
}

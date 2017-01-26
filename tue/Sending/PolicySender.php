<?php

namespace Tue\Sending;

use App\apiModels\internal\v2 as internal;
use App\Policy;
use App\TravelOffer;

class PolicySender extends SenderQueueAbstract {
   
    const TYPE = 'policy-issue-request';
    const VERSION = '2.1.0';
    const QUEUE_EXCHANGE = 'cp.out.all';
    const QUEUE_ROUTING_KEY = 'cp.out.all';

    private $_srcPolicy;

    function __construct()
    {
        parent::__construct();

        $this->setBody(new internal\Model\PolicyIssueRequest());
    }
    
    public function setPolicy(Policy $policy)
    {
        $this->_srcPolicy = $policy;

        internal\Mappers\PolicyIssueRequestMapper::fromModel(
            $policy, $this->getBody()
        );
        
        return $this;
    }
    
    public function send()
    {
        app('log')->debug(
            "Start sending policy {$this->_srcPolicy->id} using PolicySender"
        );

        try {
            $this->setStatus($this->_srcPolicy->status);
            if (count($this->_srcPolicy->errors)) {
                $this->addError(
                    [
                        'code' => 'POLICY_ERRORS', 
                        'text' => json_encode($this->_srcPolicy->errors)
                    ]
                );
            }

            $companies = TravelOffer::getCompaniesFromElements(
                $this->_srcPolicy->product
            );
            $this->setCompany($companies);

            $this->setSrcId($this->_srcPolicy->id);
            $this->setSrcType('policy');
        } catch (\InvalidArgumentException $exception) {
            app('log')->notice('Error when setting policy to send');
            app('log')->notice($exception);

            $this->setStatus(self::STATUS_ERR);
            $this->addError(
                [
                    'code' => 'SET_POLICY',
                    'text' => 'Error when setting policy to send: '
                              . $exception->getMessage()
                ]
            );
        }

        parent::send();

        app('log')->debug(
            "End sending policy {$this->_srcPolicy->id} using PolicySender"
        );

        return $this;
    }
}
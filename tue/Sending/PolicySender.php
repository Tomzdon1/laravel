<?php

namespace Tue\Sending;

use App\apiModels\internal\v2 as internal;
use App\Policy;
use App\TravelOffer;

class PolicySender extends SenderQueueAbstract {
   
    const TYPE = 'policy-issue-request';
    const VERSION = '2.0.0';
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
        app('log')->debug('Start sendPolicy');

        try {
            $this->setStatus($this->_srcPolicy->status);
            if (count($this->_srcPolicy->errors)) {
                $this->addErrors(
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
            app('log')->error('Error when setting issued policy to send');
            app('log')->error($exception);
            $this->setStatus(self::STATUS_ERR);
            $this->addErrors(
                [
                    'code' => 'SET_POLICY',
                    'text' => 'Error when setting issued policy to send: '
                              . $exception->getMessage()
                ]
            );
        }

        parent::send();

        app('log')->debug('End sendPolicy');

        return $this;
    }
}

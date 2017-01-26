<?php

namespace Tue\Sending;

use App\Policy;
use App\TravelOffer;
use App\apiModels\internal\v2 as internal;

class PolicySmsNotificationSender extends SmsSender {

    public function setPolicy(Policy $policy)
    {
        $this->_srcPolicy = $policy;
        
        return $this;
    }
   
    public function send()
    {
        app('log')->debug(
            "Start sending policy sms notification for policy 
            {$this->_srcPolicy->id} using PolicySmsNotificationSender"
        );

        if (isset($this->_srcPolicy->policy_holder->telephone) 
            && isset($this->_srcPolicy->product->configuration->smsTemplate) 
            && isset($this->_srcPolicy->product->configuration->smsCampId) 
            && (($this->_srcPolicy->getSource() == 'import' && $this->_srcPolicy->product->configuration->smsOnImport)
            || ($this->_srcPolicy->getSource() == 'issue' && $this->_srcPolicy->product->configuration->smsOnIssue))
        ) {
            try {
                $smsSendRequest = $this->getBody();

                $messageValues = [];

                $messageValueClassName = substr($smsSendRequest->swaggerTypes()['message'], 0, -2);
                $messageValue = new $messageValueClassName;
                $messageValue->setKey('wiad_par_z01');
                $template = $this->_srcPolicy->product->configuration->smsTemplate;
                $parser = app()->make('TemplateParserFromObject');
                $messageValue->setValue($parser::parse($template, $this->_srcPolicy));
                $messageValues[] = $messageValue;

                $smsSendRequest->setCampaignId((string) $this->_srcPolicy->product->configuration->smsCampId);
                $smsSendRequest->setMessage($messageValues);
                $smsSendRequest->setTelephone($this->_srcPolicy->policy_holder->telephone);

                $companies = TravelOffer::getCompaniesFromElements(
                    $this->_srcPolicy->product
                );
                $this->setCompany($companies);

                $this->setSrcId($this->_srcPolicy->id);
                $this->setSrcType('policy');
            } catch (\InvalidArgumentException $exception) {
                app('log')->notice('Error when setting policy sms notification to send');
                app('log')->notice($exception);
                $this->setStatus(self::STATUS_ERR);
                $this->addError(
                    [
                        'code' => 'SET_POLICY_SMS_NOTIFICATION',
                        'text' => 'Error when setting policy sms notification to send: '
                                . $exception->getMessage()
                    ]
                );
            }
            parent::send();
        } else {
            app('log')->debug(
                "Policy sms notification for policy {$this->_srcPolicy->id} 
                wasn't send because policy didn't meet the conditions for sending"
            );
        }

        app('log')->debug(
            "End sending policy sms notification for policy 
            {$this->_srcPolicy->id} using PolicySmsNotificationSender"
        );

        return $this;
    }
}

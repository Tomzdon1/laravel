<?php

namespace App\Listeners;

use App\Events\IssuedPolicyEvent;

class SendSMSNotificationIssuedPolicy extends Listener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * Handle the event.
     *
     * @param  ExampleEvent  $event
     * @return void
     */
    public function handle(IssuedPolicyEvent $event)
    {
        app('log')->debug('Start SendSMSNotificationIssuedPolicy');

        // @todo Do usunięcia stąd (np. przechowywać w bazie)
        $event->policy->product['company'] = ['M'];

        if (isset($event->policy->policy_holder->telephone) && isset($event->policy->product['configuration']['smsCampId']) &&
            ($event->policy->getSource() == 'import' && $event->policy->product['configuration']['smsOnImport']) || 
            ($event->policy->getSource() == 'issue' && $event->policy->product['configuration']['smsOnIssue'])) {

                $smsSender = app()->make('SmsSender');

                try {
                    $SmsSendRequest = $smsSender->getBody();

                    $messageValues = [];

                    $messageValueClassName = substr($SmsSendRequest->swaggerTypes()['message'], 0, -2);
                    $messageValue = new $messageValueClassName;
                    $messageValue->setKey('wiad_par_z01');
                    $template = '[CP TEST] policyId: [id]'; 
                    $parser = app()->make('TemplateParserFromObject');
                    $messageValue->setValue($parser::parse($template, $event->policy));
                    $messageValues[] = $messageValue;

                    $SmsSendRequest->setCampaignId($event->policy->product['configuration']['smsCampId']);
                    $SmsSendRequest->setMessage($messageValues);
                    $SmsSendRequest->setTelephone($event->policy->policy_holder->telephone);
                } catch (\InvalidArgumentException $exception) {
                    $smsSender->setStatus($policySender::STATUS_ERR);
                }

                $smsSender->setSrcId($event->policy->id);
                $smsSender->setCompany($event->policy->product['company']);
                $smsSender->send();
        }

        app('log')->debug('End SendSMSNotificationIssuedPolicy');
    }
}

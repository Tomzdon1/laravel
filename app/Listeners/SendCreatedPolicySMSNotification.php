<?php

namespace App\Listeners;

use App\Events\CreatedPolicyEvent;

class SendCreatedPolicySMSNotification extends Listener
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
    public function handle(CreatedPolicyEvent $event)
    {
        app('log')->info('Start SendCreatedPolicySMSNotification listener');

        if (isset($event->policy->policy_holder->telephone) &&
            isset($event->policy->product->configuration->smsTemplate) &&
            isset($event->policy->product->configuration->smsCampId) &&
            ($event->policy->getSource() == 'import' && $event->policy->product->configuration->smsOnImport) ||
            ($event->policy->getSource() == 'issue' && $event->policy->product->configuration->smsOnIssue)
        ) {
            $smsSender = app()->make('SmsSender');

            try {
                $smsSendRequest = $smsSender->getBody();

                $messageValues = [];

                $messageValueClassName = substr($smsSendRequest->swaggerTypes()['message'], 0, -2);
                $messageValue = new $messageValueClassName;
                $messageValue->setKey('wiad_par_z01');
                $template = $event->policy->product->configuration->smsTemplate;
                $parser = app()->make('TemplateParserFromObject');
                $messageValue->setValue($parser::parse($template, $event->policy));
                $messageValues[] = $messageValue;

                $smsSendRequest->setCampaignId((string) $event->policy->product->configuration->smsCampId);
                $smsSendRequest->setMessage($messageValues);
                $smsSendRequest->setTelephone($event->policy->policy_holder->telephone);

                $companies = [];
                foreach ($event->policy->product->elements as $element) {
                    array_push($companies, $element->cmp);
                }
                $companies = array_unique($companies);

                $smsSender->setCompany($companies);
            } catch (\InvalidArgumentException $exception) {
                $smsSender->setStatus($policySender::STATUS_ERR);
            }

            $smsSender->setSrcId($event->policy->id);
            $smsSender->setSrcType('policy');
            $smsSender->send();
        }

        app('log')->info('End SendCreatedPolicySMSNotification listener');
    }
}

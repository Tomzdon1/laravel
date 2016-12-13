<?php

namespace App\Listeners;

use App\Events\CreatedPolicyEvent;

class SendCreatedPolicyMailNotification extends Listener
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
        !env('APP_DEBUG', false) ?: app('log')->debug('Start SendCreatedPolicyMailNotification');

        if (isset($event->policy->policy_holder->email) &&
            isset($event->policy->product->configuration->mailTemplate) &&
            ($event->policy->getSource() == 'import' && $event->policy->product->configuration->mailOnImport) ||
            ($event->policy->getSource() == 'issue' && $event->policy->product->configuration->mailOnIssue)
        ) {
            $mailSender = app()->make('MailSender');

            try {
                $mailSendRequest = $mailSender->getBody();
                $template = $event->policy->product->configuration->mailTemplate;
                $parser = app()->make('TemplateParserFromObject');
                $mailSendRequest->setRecipient($event->policy->policy_holder->email);
                $mailSendRequest->setSubject($event->policy->product->configuration->mailSubject);
                $mailSendRequest->setBody($parser::parse($template, $event->policy));
                // @todo Pobieranie i załączanie plików z PrintOUT
                $mailSender->attach('example.pdf');

                $companies = [];
                foreach ($event->policy->product->elements as $element) {
                    array_push($companies, $element->cmp);
                }
                $companies = array_unique($companies);

                $mailSender->setCompany($companies);
            } catch (\InvalidArgumentException $exception) {
                $mailSender->setStatus($policySender::STATUS_ERR);
            }

            $mailSender->setSrcId($event->policy->id);
            $mailSender->setSrcType('policy');
            $mailSender->send();
        }

        !env('APP_DEBUG', false) ?: app('log')->debug('End SendCreatedPolicyMailNotification');
    }
}

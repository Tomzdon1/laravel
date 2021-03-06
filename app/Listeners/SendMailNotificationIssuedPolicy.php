<?php

namespace App\Listeners;

use App\Events\IssuedPolicyEvent;

class SendMailNotificationIssuedPolicy extends Listener
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
        app('log')->debug('Start SendMailNotificationIssuedPolicy');

        if (isset($event->policy->policy_holder->email) &&
            isset($event->policy->product['configuration']['mailTemplate']) &&
            ($event->policy->getSource() == 'import' && $event->policy->product['configuration']['mailOnImport']) ||
            ($event->policy->getSource() == 'issue' && $event->policy->product['configuration']['mailOnIssue'])) {
            $mailSender = app()->make('MailSender');

            try {
                $mailSendRequest = $mailSender->getBody();
                $template = $event->policy->product['configuration']['mailTemplate'];
                $parser = app()->make('TemplateParserFromObject');
                $mailSendRequest->setRecipient($event->policy->policy_holder->email);
                $mailSendRequest->setSubject($event->policy->product['configuration']['mailSubject']);
                $mailSendRequest->setBody($parser::parse($template, $event->policy));
                // @todo Skąd pobrać załączniki
                $mailSendRequest->setAttachments([]);

                $product = json_decode($event->policy->product);

                $companies = [];
                foreach ($product->elements as $element) {
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

        app('log')->debug('End SendMailNotificationIssuedPolicy');
    }
}

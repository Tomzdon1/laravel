<?php

namespace App\Listeners;

use App\Events\IssuedPolicyEvent;

class SendIssuedPolicy extends Listener
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
        app('log')->debug('Start SendIssuedPolicy');

        // @todo Do usunięcia stąd (np. przechowywać w bazie)
        $event->policy->product['company'] = ['M'];

        $policySender = app()->make('PolicySender');
                
        try {
            $policySender->setPolicy($event->policy);
        } catch (\InvalidArgumentException $exception) {
            $policySender->setStatus($policySender::STATUS_ERR);
        }

        $policySender->setStatus($event->policy->status);
        $policySender->setErrors($event->policy->errors);
        $policySender->setSrcId($event->policy->id);
        $policySender->setCompany($event->policy->product['company']);
        $policySender->send();

        app('log')->debug('End SendIssuedPolicy');
    }
}

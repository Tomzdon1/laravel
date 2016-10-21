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
        $policySender->setStatus($event->policy->status);
        $policySender->addErrors(['code' => 'POLICY_ERRORS', 'text' => json_encode($event->policy->errors)]);
        $policySender->setSrcId($event->policy->id);
        $policySender->setCompany($event->policy->product['company']);
        
        try {
            $policySender->setPolicy($event->policy);
        } catch (\InvalidArgumentException $exception) {
            app('log')->error('Error when setting issued policy to send');
            app('log')->error($exception);
            $policySender->setStatus($policySender::STATUS_ERR);
            $policySender->addErrors(['code' => 'SET_POLICY', 'text' => 'Error when setting issued policy to send: ' . $exception->getMessage()]);
        }
        
        $policySender->send();

        app('log')->debug('End SendIssuedPolicy');
    }
}

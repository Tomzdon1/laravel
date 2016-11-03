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

        $policySender = app()->make('PolicySender');
        $policySender->setStatus($event->policy->status);

        if (count($event->policy->errors)) {
            $policySender->addErrors(['code' => 'POLICY_ERRORS', 'text' => json_encode($event->policy->errors)]);
        }

        $policySender->setSrcId($event->policy->id);
        $policySender->setSrcType('policy');
        
        try {
            $policySender->setPolicy($event->policy);

            $product = json_decode($event->policy->product);
            
            $companies = [];
            foreach ($product->elements as $element) {
                array_push($companies, $element->cmp);
            }
            $companies = array_unique($companies);

            $policySender->setCompany($companies);
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

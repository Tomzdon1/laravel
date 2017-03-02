<?php

namespace App\Listeners;

use App\Events\CreatedPolicyEvent;
use App\Policy;

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
        $policy = Policy::find($event->policy->id);
        $mailSender = app()->make('PolicyMailNotificationSender');
        $mailSender->setPolicy($policy)->send();
    }
}
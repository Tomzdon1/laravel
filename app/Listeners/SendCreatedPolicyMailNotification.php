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
        $mailSender = app()->make('PolicyMailNotificationSender');
        $mailSender->setPolicy($event->policy)->send();
    }
}
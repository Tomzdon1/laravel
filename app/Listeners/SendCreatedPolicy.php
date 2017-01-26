<?php

namespace App\Listeners;

use App\Policy;
use App\Events\CreatedPolicyEvent;

class SendCreatedPolicy extends Listener
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
     * @param CreatedPolicyEvent $event Source event
     *
     * @return void
     */
    public function handle(CreatedPolicyEvent $event)
    {
        $policy = Policy::find($event->policy->id);
        $policySender = app()->make('PolicySender');
        $policySender->setPolicy($policy)->send();
    }
}

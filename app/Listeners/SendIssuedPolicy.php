<?php

namespace App\Listeners;

use App\Policy;
use App\Events\IssuedPolicyEvent;
use Illuminate\Support\Facades\Artisan;

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
     * @param IssuedPolicyEvent $event Source event
     *
     * @return void
     */
    public function handle(IssuedPolicyEvent $event)
    {
        $policy = Policy::find($event->policy->id);
        $policySender = app()->make('PolicySender');
        $policySender->setPolicy($policy)->send();
    }
}

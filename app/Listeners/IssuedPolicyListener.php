<?php

namespace App\Listeners;

use App\Events\IssuedPolicyEvent;
use App\apiModels\internal\v1\ENVELOPE;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IssuedPolicyListener
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
        app('log')->debug('Start IssuedPolicyListener');

        $event->policy->product['company'] = 'M';

        $envelope = new ENVELOPE();
        $envelope->setBody($event->policy);
        $envelope->setType('policy');
        $envelope->setCompany($event->policy->product['company']);
        $envelope->setSrcId($event->policy->policyId->{'$id'});
        $envelope->setSendDT();

        app('queue')->pushRaw($envelope->encode());

        app('log')->debug('End IssuedPolicyListener');
    }
}
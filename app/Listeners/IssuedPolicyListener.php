<?php

namespace App\Listeners;

use App\Events\IssuedPolicyEvent;
use App\apiModels\internal\v1 as internal;
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

        $api = new internal\API();
        $api->setName(array_keys($event->policy->partnerData['apis'])[0]);
        $api->setVersion($event->policy->partnerData['apis'][$api->getName()]['version']);

        $envelope = new internal\ENVELOPE();
        $envelope->setType('policy');
        $envelope->setApi($api);
        $envelope->setStatus($event->policy->getStatus());
        $envelope->setCompany($event->policy->product['company']);
        $envelope->setSrcId($event->policy->policyId->{'$id'});
        $envelope->setSendDT(new \DateTime());
        $envelope->setBody($event->policy);

        app('queue')->pushRaw($envelope);

        app('log')->debug('End IssuedPolicyListener');
    }
}
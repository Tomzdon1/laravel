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

        // Do usunięcia stąd (np. przechowywać w bazie)
        $event->policy->product['company'] = 'M';

        $api = new internal\API();
        $api->setName(array_keys($event->policy->partner->apis)[0]);
        $api->setVersion($event->policy->partner->apis[$api->getName()]['version']);

        $envelope = new internal\ENVELOPE();
        $envelope->setType('policy');
        $envelope->setApi($api);
        $envelope->setStatus($event->policy->status);
        $envelope->setErrors($event->policy->errors);
        $envelope->setCompany($event->policy->product['company']);
        $envelope->setSrcId($event->policy->policyId);
        $envelope->setSendDT(new \DateTime());
        $envelope->setBody($event->policy);

        app('Amqp')->publish(env('RABBITMQ_ROUTING_KEY_EXPORT_POLICY'), (string) $envelope);

        app('log')->debug('End IssuedPolicyListener');
    }
}

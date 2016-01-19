<?php

namespace App\Listeners;

use App\Events\IssuedPolicyEvent;
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
        \Log::debug('Start IssuedPolicyListener');

        \Queue::pushRaw($event->policy);

        \Log::debug('End IssuedPolicyListener');
    }
}
<?php

namespace App\Listeners;

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
     * @param  ExampleEvent  $event
     * @return void
     */
    public function handle(IssuedPolicyEvent $event)
    {
        Artisan::call('policies:send', [
            'policies' => [$event->policy->id],
        ]);
    }
}

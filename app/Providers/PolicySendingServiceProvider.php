<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tue\Sending\SenderFactory;

class PolicySendingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return Tue\Sending\SmsSender
     */
    public function register()
    {
        $this->app->singleton('PolicySender', function () {
            return SenderFactory::getSender('policy');
        });

    }
}

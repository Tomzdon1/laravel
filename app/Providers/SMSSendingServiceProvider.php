<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tue\Sending\SenderFactory;

class SMSSendingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return Tue\Sending\SmsSender
     */
    public function register()
    {
        $this->app->singleton('SmsSender', function () {
            return SenderFactory::getSender('sms');
        });

    }
}

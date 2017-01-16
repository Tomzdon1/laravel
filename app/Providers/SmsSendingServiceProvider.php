<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tue\Sending\SenderFactory;

class SmsSendingServiceProvider extends ServiceProvider
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

        $this->app->singleton('PolicySmsNotificationSender', function () {
            return SenderFactory::getSender('policy-sms-notification');
        });
    }
}

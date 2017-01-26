<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tue\Sending\SenderFactory;

class MailSendingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return Tue\Sending\MailSender
     */
    public function register()
    {
        $this->app->singleton('MailSender', function () {
            return SenderFactory::getSender('mail');
        });

        $this->app->singleton('PolicyMailNotificationSender', function () {
            return SenderFactory::getSender('policy-mail-notification');
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tue\PartnerData\PartnerDataFactory;

class PartnerDataProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return Tue\PartnerData\CRMConnector
     */
    public function register()
    {
        $this->app->singleton('CRMConnector', function () {
            return PartnerDataFactory::getCRMPartnerData(env("CRM_REST_API"));
        });
    }
}

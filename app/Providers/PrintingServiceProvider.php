<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Connectors;
use Tue\Printing\PrinterFactory;

class PrintingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Printer', function(){

            return PrinterFactory::getPdfPrinter(env("PRINTOUT_WSDL"));

        });

    }
    
    
}

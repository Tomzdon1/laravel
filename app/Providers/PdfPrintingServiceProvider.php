<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tue\Printing\PrinterFactory;

class PdfPrintingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return Tue\Printing\Printer
     */
    public function register()
    {
        $this->app->singleton('PdfPrinter', function(){
            return PrinterFactory::getPdfPrinter(env("PRINTOUT_WSDL"));
        });

    }
    
    
}

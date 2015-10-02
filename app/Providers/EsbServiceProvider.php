<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Connectors;

class EsbServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ESB_conn', function(){

            return new \App\Connectors\ESB_connector();

        });
//       $this->app->bind('App\Connectors\ESB_conn', function(){
//
//            return new \App\Connectors\ESB_connector();
//
//        });
    }
    
    
}

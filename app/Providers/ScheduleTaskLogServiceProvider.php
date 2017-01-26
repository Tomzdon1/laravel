<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class ScheduleTaskLogServiceProvider extends ServiceProvider
{
    /**
     * Register container bindings for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ScheduleTaskLogger', function () {
            return new Logger('lumen', [(new StreamHandler(storage_path('logs/schedule_task.log'), Logger::DEBUG))
                            ->setFormatter(new LineFormatter(null, null, true, true))]);
        });
    }
}

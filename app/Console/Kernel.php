<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\ConsumeQueue::class,
        \App\Console\Commands\SendPolicy::class,
        \App\Console\Commands\SendPolicySmsNotification::class,
        \App\Console\Commands\SendPolicyMailNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:consume')
                 ->everyMinute()
                 ->withoutOverlapping()
                 ->before(function () {
                     app('ScheduleTaskLogger')->info('START: Call ConsumeQueue command');
                 })
                 ->after(function () {
                     app('ScheduleTaskLogger')->info('END: After call ConsumeQueue command');
                 });
    }
}

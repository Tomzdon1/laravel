<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Policy;

class SendPolicySmsNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'policies:sendSmsNotification {policies*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS notification for policies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app('log')->info('Run SendPolicySmsNotification command');

        if ($this->argument('policies')) {
            $policiesId = $this->argument('policies');
        }
        
        $policies = Policy::find($policiesId);
        $bar = $this->output->createProgressBar(count($policies));
        $bar->setFormat("%current%/%max% [%bar%] %message%\n");

        foreach ($policies as $policy) {
            $bar->setMessage("Launch SendPolicySmsNotification for $policy->_id (policy_number: $policy->policy_number)");
            $bar->advance();
            $this->_send($policy);
        }

        $bar->finish();

        app('log')->info('End SendPolicySmsNotification command');
    }

    /**
     * Send SMS notification for policy.
     *
     * @param Policy $policy policy for which to send notification
     *
     * @return void
     */
    private function _send(Policy $policy)
    {
        $smsSender = app()->make('PolicySmsNotificationSender');
        $smsSender->setPolicy($policy)->send();
    }
}

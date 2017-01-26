<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Policy;

class SendPolicyMailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'policies:sendMailNotification {policies*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail notification for policies';

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
        app('log')->debug('Run SendPolicyMailNotification command');

        if ($this->argument('policies')) {
            $policiesId = $this->argument('policies');
        }
        
        $policies = Policy::find($policiesId);
        $bar = $this->output->createProgressBar(count($policies));
        $bar->setFormat("%current%/%max% [%bar%] %message%\n");

        foreach ($policies as $policy) {
            $bar->setMessage("Launch SendPolicyMailNotification for $policy->_id (policy_number: $policy->policy_number)");
            $bar->advance();
            $this->_send($policy);
        }

        $bar->finish();

        app('log')->debug('End SendPolicyMailNotification command');
    }

    /**
     * Send Mail notification for policy.
     *
     * @param Policy $policy policy for which to send notification
     *
     * @return void
     */
    private function _send(Policy $policy)
    {
        $mailSender = app()->make('PolicyMailNotificationSender');
        $mailSender->setPolicy($policy)->send();
    }
}

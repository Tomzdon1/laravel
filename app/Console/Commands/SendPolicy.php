<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Policy;

class SendPolicy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'policies:send {policies*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send definied policies to external system';

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
        !env('APP_DEBUG', false) ?: app('log')->debug('Run SendPolicy command');

        if ($this->argument('policies')) {
            $policiesId = $this->argument('policies');
        }
        
        $policies = Policy::find($policiesId);
        $bar = $this->output->createProgressBar(count($policies));
        $bar->setFormat("%current%/%max% [%bar%] %message%\n");

        foreach ($policies as $policy) {
            $bar->setMessage("Launch sendPolicy for $policy->_id (policy_number: $policy->policy_number)");
            $bar->advance();
            $this->_send($policy);
        }

        $bar->finish();

        !env('APP_DEBUG', false) ?: app('log')->debug('End SendPolicy command');
    }

    /**
     * Send policy to external system.
     *
     * @param Policy $policy policy to send
     *
     * @return void
     */
    private function _send(Policy $policy)
    {
        $policySender = app()->make('PolicySender');
        $policySender->setPolicy($policy)->send();
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Policy;
use App\Events\IssuedPolicyEvent;

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
        app('log')->debug('Run SendPolicy command');

        if ($this->argument('policies')) {
            $policiesId = $this->argument('policies');
        }
        
        $policies = Policy::find($policiesId);
        $bar = $this->output->createProgressBar(count($policies));
        $bar->setFormat("%current%/%max% [%bar%] %message%\n");

        foreach ($policies as $policy) {
            $bar->setMessage("Launch sendPolicy for $policy->_id (policy_number: $policy->policy_number)");
            $bar->advance();
            $this->sendPolicy($policy);
        }

        $bar->finish();

        app('log')->debug('End SendPolicy command');
    }

    /**
     * Send policy to external system.
     *
     * @param $policy policy to send
     */
    private function sendPolicy(Policy $policy)
    {
        app('log')->debug('Start sendPolicy');

        $policySender = app()->make('PolicySender');
        $policySender->setStatus($policy->status);

        if (count($policy->errors)) {
            $policySender->addErrors(['code' => 'POLICY_ERRORS', 'text' => json_encode($policy->errors)]);
        }

        $policySender->setSrcId($policy->id);
        $policySender->setSrcType('policy');
        
        try {
            $policySender->setPolicy($policy);

            $product = json_decode(json_encode($policy->product));

            $companies = [];
            foreach ($product->elements as $element) {
                array_push($companies, $element->cmp);
            }
            $companies = array_unique($companies);

            $policySender->setCompany($companies);
        } catch (\InvalidArgumentException $exception) {
            app('log')->error('Error when setting issued policy to send');
            app('log')->error($exception);
            $policySender->setStatus($policySender::STATUS_ERR);
            $policySender->addErrors([
                'code' => 'SET_POLICY',
                'text' => 'Error when setting issued policy to send: ' . $exception->getMessage()
            ]);
        }
        
        $policySender->send();

        app('log')->debug('End sendPolicy');
    }
}

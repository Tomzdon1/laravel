<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConsumeQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:consume {queue?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume messages from definied or env-specified queue';

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
        app('log')->info('Run ConsumeQueue command');

        $queueToConsume = env('RABBITMQ_CONSUME_QUEUE', 'cp');

        if ($this->argument('queue')) {
            $queueToConsume = $this->argument('queue');
        }
        
        app('Amqp')->consume($queueToConsume, function ($message, $resolver) {
            $envelope = json_decode($message->body);

            if ($envelope) {
                switch ($envelope->type) {
                    case 'mail-status':
                    case 'sms-status':
                    case 'policy-status':
                        dispatch(new \App\Jobs\SaveConfirmationToPolicy($envelope));
                        $resolver->acknowledge($message);
                        break;
                }
            }
        }, [
            'persistent' => env('RABBITMQ_CONSUME_QUEUE_PERSISTENT', true),
            'timeout' => env('RABBITMQ_CONSUME_QUEUE_TIMEOUT', 60),
            'queue_durable' => env('RABBITMQ_CONSUME_QUEUE_DURABLE', true),
        ]);

        app('log')->info('End ConsumeQueue command');
    }
}

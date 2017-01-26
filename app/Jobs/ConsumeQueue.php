<?php

namespace App\Jobs;

class ConsumeQueue extends Job
{

    protected $podcast;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($podcast = null)
    {
        $this->podcast = $podcast;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app('log')->debug('Run job ConsumeQueue');

        app('Amqp')->consume(env('RABBITMQ_CONSUME_QUEUE', 'cp'), function ($message, $resolver) {
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
    }
}

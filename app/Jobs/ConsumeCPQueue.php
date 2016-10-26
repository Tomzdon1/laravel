<?php

namespace App\Jobs;

// @ todo poprawic nazwe w zaleznosci od kolekcji
class ConsumeCPQueue extends Job
{
    protected $podcast;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($podcast=null)
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
        app('log')->debug('Run job ConsumeCPQueue');
        
        app('Amqp')->consume('sub.out.all', function ($message, $resolver) {
            $envelope = json_decode($message->body);
           
            if ($envelope) {
                switch ($envelope->type) {
                    case 'mail-status':
                        $resolver->acknowledge($message);
                        dispatch(new \App\Jobs\SaveMailConfirmation($message->body));
                        break;
                    case 'sms-status':
                        $resolver->acknowledge($message);
                        dispatch(new \App\Jobs\SaveSMSConfirmation($message->body));
                        break;
                    case 'policy-status':
                        $resolver->acknowledge($message);
                        dispatch(new \App\Jobs\SaveIssuedPolicyConfirmation($message->body));
                        break;
                }
            }
            
            // uncomment if want to stop and run again (depends on sheduler) consumer after processed
            // $resolver->stopWhenProcessed();

        }, [
            'persistent' => true, // required if you want to listen forever
        ]);
    }
}
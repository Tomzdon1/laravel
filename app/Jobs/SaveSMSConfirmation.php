<?php

namespace App\Jobs;

class SaveSMSConfirmation extends Job
{
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // @ todo zaimplementować
        app('log')->debug('Job SaveSMSConfirmation run! Example variable "$message" value: ' . $this->message);
    }
}
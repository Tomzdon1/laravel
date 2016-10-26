<?php

namespace App\Jobs;

class SaveMailConfirmation extends Job
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
        app('log')->debug('Job SaveMailConfirmation run! Example variable "$message" value: ' . $this->message);
    }
}
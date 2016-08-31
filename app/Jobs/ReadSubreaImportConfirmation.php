<?php

namespace App\Jobs;

class ReadSubreaImportConfirmation extends Job
{
    protected $podcast;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($podcast)
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
        app('log')->debug('Job ReadSubreaImportConfirmation run! Example variable "$podcast" value: ' . $this->podcast);
    }
}
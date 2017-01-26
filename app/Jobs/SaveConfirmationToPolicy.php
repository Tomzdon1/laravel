<?php

namespace App\Jobs;

use App\Policy;

class SaveConfirmationToPolicy extends Job
{
    protected $envelope;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($envelope)
    {
        $this->envelope = $envelope;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app('log')->info('Run SaveConfirmationToPolicy job');
        
        if ($this->envelope) {
            $policy = Policy::find($this->envelope->dst_id);

            if ($policy) {
                $policy->addStatus($this->envelope);
                $policy->save();
                app('log')->info("Status type {$this->envelope->type} for policy $policy->id saved");
            } else {
                //sprawdzic jak to sie zachowa w logach, powinien byc tu error log
                throw new \Exception('Not found policy for status: ' . json_encode($this->envelope));
            }
        } else {
            //sprawdzic jak to sie zachowa w logach, powinien byc tu error log
            throw new \Exception('Not valid envelope');
        }

        app('log')->info('End SaveConfirmationToPolicy job');
    }
}

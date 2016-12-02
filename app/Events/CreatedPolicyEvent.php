<?php

namespace App\Events;

class CreatedPolicyEvent extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($policy)
    {
        $this->policy = $policy;
    }
}

<?php

namespace Ugarit\Horizon\Events;

class JobDeleted extends RedisEvent
{
    /**
     * The queue job instance.
     *
     * @var \Heritage\Queue\Jobs\Job
     */
    public $job;

    /**
     * Create a new event instance.
     *
     * @param  \Heritage\Queue\Jobs\Job  $job
     * @param  string  $payload
     * @return void
     */
    public function __construct($job, $payload)
    {
        $this->job = $job;

        parent::__construct($payload);
    }
}

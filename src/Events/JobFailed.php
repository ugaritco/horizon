<?php

namespace Ugarit\Horizon\Events;

class JobFailed extends RedisEvent
{
    /**
     * The exception that caused the failure.
     *
     * @var \Exception
     */
    public $exception;

    /**
     * The queue job instance.
     *
     * @var \Heritage\Queue\Jobs\Job
     */
    public $job;

    /**
     * Create a new event instance.
     *
     * @param  \Exception  $exception
     * @param  \Heritage\Queue\Jobs\Job  $job
     * @param  string  $payload
     * @return void
     */
    public function __construct($exception, $job, $payload)
    {
        $this->job = $job;
        $this->exception = $exception;

        parent::__construct($payload);
    }
}

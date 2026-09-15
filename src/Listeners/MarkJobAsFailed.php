<?php

namespace Ugarit\Horizon\Listeners;

use Ugarit\Horizon\Contracts\JobRepository;
use Ugarit\Horizon\Events\JobFailed;

class MarkJobAsFailed
{
    /**
     * The job repository implementation.
     *
     * @var \Ugarit\Horizon\Contracts\JobRepository
     */
    public $jobs;

    /**
     * Create a new listener instance.
     *
     * @param  \Ugarit\Horizon\Contracts\JobRepository  $jobs
     * @return void
     */
    public function __construct(JobRepository $jobs)
    {
        $this->jobs = $jobs;
    }

    /**
     * Handle the event.
     *
     * @param  \Ugarit\Horizon\Events\JobFailed  $event
     * @return void
     */
    public function handle(JobFailed $event)
    {
        $this->jobs->failed(
            $event->exception, $event->connectionName,
            $event->queue, $event->payload
        );
    }
}

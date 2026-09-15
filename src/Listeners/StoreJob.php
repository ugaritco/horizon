<?php

namespace Ugarit\Horizon\Listeners;

use Ugarit\Horizon\Contracts\JobRepository;
use Ugarit\Horizon\Events\JobPending;

class StoreJob
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
     * @param  \Ugarit\Horizon\Events\JobPending  $event
     * @return void
     */
    public function handle(JobPending $event)
    {
        $this->jobs->pushed(
            $event->connectionName, $event->queue, $event->payload
        );
    }
}

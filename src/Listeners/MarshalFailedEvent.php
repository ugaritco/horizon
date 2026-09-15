<?php

namespace Ugarit\Horizon\Listeners;

use Heritage\Contracts\Events\Dispatcher;
use Heritage\Queue\Events\JobFailed as UgaritJobFailed;
use Heritage\Queue\Jobs\RedisJob;
use Ugarit\Horizon\Events\JobFailed;

class MarshalFailedEvent
{
    /**
     * The event dispatcher implementation.
     *
     * @var \Heritage\Contracts\Events\Dispatcher
     */
    public $events;

    /**
     * Create a new listener instance.
     *
     * @param  \Heritage\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    /**
     * Handle the event.
     *
     * @param  \Heritage\Queue\Events\JobFailed  $event
     * @return void
     */
    public function handle(UgaritJobFailed $event)
    {
        if (! $event->job instanceof RedisJob) {
            return;
        }

        $this->events->dispatch((new JobFailed(
            $event->exception, $event->job, $event->job->getReservedJob()
        ))->connection($event->connectionName)->queue($event->job->getQueue()));
    }
}

<?php

namespace Ugarit\Horizon\Listeners;

use Ugarit\Horizon\Events\JobReserved;
use Ugarit\Horizon\Stopwatch;

class StartTimingJob
{
    /**
     * The stopwatch instance.
     *
     * @var \Ugarit\Horizon\Stopwatch
     */
    public $watch;

    /**
     * Create a new listener instance.
     *
     * @param  \Ugarit\Horizon\Stopwatch  $watch
     * @return void
     */
    public function __construct(Stopwatch $watch)
    {
        $this->watch = $watch;
    }

    /**
     * Handle the event.
     *
     * @param  \Ugarit\Horizon\Events\JobReserved  $event
     * @return void
     */
    public function handle(JobReserved $event)
    {
        $this->watch->start($event->payload->id());
    }
}

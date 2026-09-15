<?php

namespace Ugarit\Horizon\Listeners;

use Ugarit\Horizon\Stopwatch;

class ForgetJobTimer
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
     * @param  \Heritage\Queue\Events\JobExceptionOccurred|\Heritage\Queue\Events\JobFailed  $event
     * @return void
     */
    public function handle($event)
    {
        $this->watch->forget($event->job->getJobId());
    }
}

<?php

namespace Ugarit\Horizon\Listeners;

use Ugarit\Horizon\Contracts\MetricsRepository;
use Ugarit\Horizon\Events\JobDeleted;
use Ugarit\Horizon\Stopwatch;

class UpdateJobMetrics
{
    /**
     * The metrics repository implementation.
     *
     * @var \Ugarit\Horizon\Contracts\MetricsRepository
     */
    public $metrics;

    /**
     * The stopwatch instance.
     *
     * @var \Ugarit\Horizon\Stopwatch
     */
    public $watch;

    /**
     * Create a new listener instance.
     *
     * @param  \Ugarit\Horizon\Contracts\MetricsRepository  $metrics
     * @param  \Ugarit\Horizon\Stopwatch  $watch
     * @return void
     */
    public function __construct(MetricsRepository $metrics, Stopwatch $watch)
    {
        $this->watch = $watch;
        $this->metrics = $metrics;
    }

    /**
     * Stop gathering metrics for a job.
     *
     * @param  \Ugarit\Horizon\Events\JobDeleted  $event
     * @return void
     */
    public function handle(JobDeleted $event)
    {
        if ($event->job->hasFailed()) {
            return;
        }

        $time = $this->watch->check($id = $event->payload->id()) ?: 0;

        $this->metrics->incrementQueue(
            $event->job->getQueue(), $time
        );

        $this->metrics->incrementJob(
            $event->payload->displayName(), $time
        );

        $this->watch->forget($id);
    }
}

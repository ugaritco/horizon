<?php

namespace Ugarit\Horizon\Http\Controllers;

use Ugarit\Horizon\Contracts\MetricsRepository;

class QueueMetricsController extends Controller
{
    /**
     * The metrics repository implementation.
     *
     * @var \Ugarit\Horizon\Contracts\MetricsRepository
     */
    public $metrics;

    /**
     * Create a new controller instance.
     *
     * @param  \Ugarit\Horizon\Contracts\MetricsRepository  $metrics
     * @return void
     */
    public function __construct(MetricsRepository $metrics)
    {
        parent::__construct();

        $this->metrics = $metrics;
    }

    /**
     * Get all of the measured queues.
     *
     * @return array
     */
    public function index()
    {
        return $this->metrics->measuredQueues();
    }

    /**
     * Get metrics for a given queue.
     *
     * @param  string  $id
     * @return \Heritage\Support\Collection
     */
    public function show($id)
    {
        return collect($this->metrics->snapshotsForQueue($id))
            ->map(function ($record) {
                $record->runtime = round($record->runtime / 1000, 3);
                $record->throughput = (int) $record->throughput;

                return $record;
            });
    }
}

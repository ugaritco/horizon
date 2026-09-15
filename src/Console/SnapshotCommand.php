<?php

namespace Ugarit\Horizon\Console;

use Heritage\Console\Command;
use Ugarit\Horizon\Contracts\MetricsRepository;
use Ugarit\Horizon\Lock;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'horizon:snapshot')]
class SnapshotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'horizon:snapshot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store a snapshot of the queue metrics';

    /**
     * Execute the console command.
     *
     * @param  \Ugarit\Horizon\Lock  $lock
     * @param  \Ugarit\Horizon\Contracts\MetricsRepository  $metrics
     * @return void
     */
    public function handle(Lock $lock, MetricsRepository $metrics)
    {
        if ($lock->get('metrics:snapshot', config('horizon.metrics.snapshot_lock', 300) - 30)) {
            $metrics->snapshot();

            $this->components->info('Metrics snapshot stored successfully.');
        }
    }
}

<?php

namespace Ugarit\Horizon\Console;

use Heritage\Console\Command;
use Heritage\Console\ConfirmableTrait;
use Heritage\Queue\QueueManager;
use Heritage\Support\Arr;
use Ugarit\Horizon\Contracts\JobRepository;
use Ugarit\Horizon\RedisQueue;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'horizon:clear')]
class ClearCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'horizon:clear
                            {connection? : The name of the queue connection}
                            {--queue= : The name of the queue to clear}
                            {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all of the jobs from the specified queue';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle(JobRepository $jobRepository, QueueManager $manager)
    {
        if (! $this->confirmToProceed()) {
            return 1;
        }

        if (! method_exists(RedisQueue::class, 'clear')) {
            $this->components->error('Clearing queues is not supported on this version of Ugarit.');

            return 1;
        }

        $connection = $this->argument('connection')
            ?: Arr::first($this->ugarit['config']->get('horizon.defaults'))['connection'] ?? 'redis';

        if (method_exists($jobRepository, 'purge')) {
            $jobRepository->purge($queue = $this->getQueue($connection));
        }

        $count = $manager->connection($connection)->clear($queue);

        $this->components->info('Cleared '.$count.' jobs from the ['.$queue.'] queue.');

        return 0;
    }

    /**
     * Get the queue name to clear.
     *
     * @param  string  $connection
     * @return string
     */
    protected function getQueue($connection)
    {
        return $this->option('queue') ?: $this->ugarit['config']->get(
            "queue.connections.{$connection}.queue",
            'default'
        );
    }
}

<?php

require __DIR__.'/../vendor/autoload.php';

use Heritage\Contracts\Debug\ExceptionHandler;
use Heritage\Contracts\Events\Dispatcher;
use Heritage\Queue\QueueManager;
use Heritage\Queue\Worker;
use Heritage\Queue\WorkerOptions;
use Ugarit\Horizon\Tests\RedisClusterHelper;

use function Orchestra\Testbench\container;

// Configure the application...
$app = container()->createApplication();
$app->make('config')->set('queue.default', 'redis');

RedisClusterHelper::configure($app);

$worker = new Worker(
    $app->make(QueueManager::class),
    $app->make(Dispatcher::class),
    $app->make(ExceptionHandler::class),
    function () use ($app) {
        return $app->isDownForMaintenance();
    }
);

// Pause the worker if needed...
if (in_array('--paused', $_SERVER['argv'])) {
    $worker->paused = true;
}

// Start the daemon loop.
$worker->daemon(
    'redis', 'default', new WorkerOptions
);

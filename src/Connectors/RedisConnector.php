<?php

namespace Ugarit\Horizon\Connectors;

use Heritage\Queue\Connectors\RedisConnector as BaseConnector;
use Heritage\Support\Arr;
use Ugarit\Horizon\RedisQueue;

class RedisConnector extends BaseConnector
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Ugarit\Horizon\RedisQueue
     */
    public function connect(array $config)
    {
        return new RedisQueue(
            $this->redis, $config['queue'],
            Arr::get($config, 'connection', $this->connection),
            Arr::get($config, 'retry_after', 60),
            Arr::get($config, 'block_for', null),
            Arr::get($config, 'after_commit', null)
        );
    }
}

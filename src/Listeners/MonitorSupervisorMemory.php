<?php

namespace Ugarit\Horizon\Listeners;

use Ugarit\Horizon\Events\SupervisorLooped;
use Ugarit\Horizon\Events\SupervisorOutOfMemory;

class MonitorSupervisorMemory
{
    /**
     * Handle the event.
     *
     * @param  \Ugarit\Horizon\Events\SupervisorLooped  $event
     * @return void
     */
    public function handle(SupervisorLooped $event)
    {
        $supervisor = $event->supervisor;

        if (($memoryUsage = $supervisor->memoryUsage()) > $supervisor->options->memory) {
            event((new SupervisorOutOfMemory($supervisor))->setMemoryUsage($memoryUsage));

            $supervisor->terminate(12);
        }
    }
}

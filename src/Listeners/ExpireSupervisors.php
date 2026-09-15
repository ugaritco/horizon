<?php

namespace Ugarit\Horizon\Listeners;

use Ugarit\Horizon\Contracts\MasterSupervisorRepository;
use Ugarit\Horizon\Contracts\SupervisorRepository;
use Ugarit\Horizon\Events\MasterSupervisorLooped;

class ExpireSupervisors
{
    /**
     * Handle the event.
     *
     * @param  \Ugarit\Horizon\Events\MasterSupervisorLooped  $event
     * @return void
     */
    public function handle(MasterSupervisorLooped $event)
    {
        app(MasterSupervisorRepository::class)->flushExpired();

        app(SupervisorRepository::class)->flushExpired();
    }
}

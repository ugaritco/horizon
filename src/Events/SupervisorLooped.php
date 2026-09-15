<?php

namespace Ugarit\Horizon\Events;

use Ugarit\Horizon\Supervisor;

class SupervisorLooped
{
    /**
     * The supervisor instance.
     *
     * @var \Ugarit\Horizon\Supervisor
     */
    public $supervisor;

    /**
     * Create a new event instance.
     *
     * @param  \Ugarit\Horizon\Supervisor  $supervisor
     * @return void
     */
    public function __construct(Supervisor $supervisor)
    {
        $this->supervisor = $supervisor;
    }
}

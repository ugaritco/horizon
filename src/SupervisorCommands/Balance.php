<?php

namespace Ugarit\Horizon\SupervisorCommands;

use Ugarit\Horizon\Supervisor;

class Balance
{
    /**
     * Process the command.
     *
     * @param  \Ugarit\Horizon\Supervisor  $supervisor
     * @param  array  $options
     * @return void
     */
    public function process(Supervisor $supervisor, array $options)
    {
        $supervisor->balance($options);
    }
}

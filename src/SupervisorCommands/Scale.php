<?php

namespace Ugarit\Horizon\SupervisorCommands;

use Ugarit\Horizon\Supervisor;

class Scale
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
        $supervisor->scale($options['scale']);
    }
}

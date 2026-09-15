<?php

namespace Ugarit\Horizon\SupervisorCommands;

use Ugarit\Horizon\Contracts\Restartable;

class Restart
{
    /**
     * Process the command.
     *
     * @param  \Ugarit\Horizon\Contracts\Restartable  $restartable
     * @return void
     */
    public function process(Restartable $restartable)
    {
        $restartable->restart();
    }
}

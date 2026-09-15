<?php

namespace Ugarit\Horizon\SupervisorCommands;

use Ugarit\Horizon\Contracts\Pausable;

class Pause
{
    /**
     * Process the command.
     *
     * @param  \Ugarit\Horizon\Contracts\Pausable  $pausable
     * @return void
     */
    public function process(Pausable $pausable)
    {
        $pausable->pause();
    }
}

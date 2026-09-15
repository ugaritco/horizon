<?php

namespace Ugarit\Horizon\Tests\Feature\Fakes;

use Ugarit\Horizon\Supervisor;

class SupervisorWithFakeExit extends Supervisor
{
    public $exited = false;

    /**
     * End the current PHP process.
     *
     * @param  int  $status
     * @return void
     */
    protected function exitProcess($status = 0)
    {
        $this->exited = true;
    }
}

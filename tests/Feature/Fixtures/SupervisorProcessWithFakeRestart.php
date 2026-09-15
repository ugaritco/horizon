<?php

namespace Ugarit\Horizon\Tests\Feature\Fixtures;

use Ugarit\Horizon\SupervisorProcess;

class SupervisorProcessWithFakeRestart extends SupervisorProcess
{
    public $wasRestarted = false;

    public function restart()
    {
        $this->wasRestarted = true;
    }
}

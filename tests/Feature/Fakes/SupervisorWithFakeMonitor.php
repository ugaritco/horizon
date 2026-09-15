<?php

namespace Ugarit\Horizon\Tests\Feature\Fakes;

use Ugarit\Horizon\Supervisor;

class SupervisorWithFakeMonitor extends Supervisor
{
    public $monitoring = false;

    /**
     * {@inheritdoc}
     */
    public function monitor()
    {
        $this->monitoring = true;
    }
}

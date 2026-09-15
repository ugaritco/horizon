<?php

namespace Ugarit\Horizon\Tests\Feature\Fixtures;

use Ugarit\Horizon\SupervisorFactory;
use Ugarit\Horizon\SupervisorOptions;
use Ugarit\Horizon\Tests\Feature\Fakes\SupervisorWithFakeMonitor;

class FakeSupervisorFactory extends SupervisorFactory
{
    public $supervisor;

    public function make(SupervisorOptions $options)
    {
        return $this->supervisor = new SupervisorWithFakeMonitor($options);
    }
}

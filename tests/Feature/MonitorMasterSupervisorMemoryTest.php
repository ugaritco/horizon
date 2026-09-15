<?php

namespace Ugarit\Horizon\Tests\Feature;

use Ugarit\Horizon\Events\MasterSupervisorLooped;
use Ugarit\Horizon\Listeners\MonitorMasterSupervisorMemory;
use Ugarit\Horizon\MasterSupervisor;
use Ugarit\Horizon\Tests\IntegrationTest;
use Mockery;

class MonitorMasterSupervisorMemoryTest extends IntegrationTest
{
    public function test_supervisor_is_terminated_when_using_too_much_memory()
    {
        $monitor = new MonitorMasterSupervisorMemory;

        $master = Mockery::mock(MasterSupervisor::class);

        $master->shouldReceive('memoryUsage')->andReturn(192);
        $master->shouldReceive('output')->once()->with('error', 'Memory limit exceeded: Using 192/64MB. Consider increasing horizon.memory_limit.');
        $master->shouldReceive('terminate')->once()->with(12);

        $monitor->handle(new MasterSupervisorLooped($master));
    }

    public function test_supervisor_is_not_terminated_when_using_low_memory()
    {
        $monitor = new MonitorMasterSupervisorMemory;

        $master = Mockery::mock(MasterSupervisor::class);

        $master->shouldReceive('memoryUsage')->andReturn(16);
        $master->shouldReceive('terminate')->never();

        $monitor->handle(new MasterSupervisorLooped($master));
    }
}

<?php

namespace Ugarit\Horizon\Tests\Unit;

use Ugarit\Horizon\Supervisor;
use Ugarit\Horizon\SupervisorCommands\Scale;
use Ugarit\Horizon\Tests\UnitTest;
use Mockery;

class ScaleCommandTest extends UnitTest
{
    public function test_scale_command_tells_supervisor_to_scale()
    {
        $supervisor = Mockery::mock(Supervisor::class);
        $supervisor->shouldReceive('scale')->once()->with(3);
        $scale = new Scale;
        $scale->process($supervisor, ['scale' => 3]);
    }
}

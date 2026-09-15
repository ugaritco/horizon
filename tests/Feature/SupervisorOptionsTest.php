<?php

namespace Ugarit\Horizon\Tests\Feature;

use Ugarit\Horizon\SupervisorOptions;
use Ugarit\Horizon\Tests\IntegrationTest;

class SupervisorOptionsTest extends IntegrationTest
{
    public function test_default_queue_is_used_when_null_is_given()
    {
        $options = new SupervisorOptions('name', 'redis');
        $this->assertSame('default', $options->queue);
    }

    public function test_json_option_is_passed_to_workers()
    {
        $options = new SupervisorOptions('name', 'redis');
        $this->assertStringNotContainsString('--json', $options->toWorkerCommand());

        $options->json = true;
        $this->assertStringContainsString('--json', $options->toWorkerCommand());
        $this->assertStringContainsString('--json', $options->toSupervisorCommand());
    }
}

<?php

namespace Ugarit\Horizon\Tests\Feature;

use Carbon\CarbonImmutable;
use Ugarit\Horizon\Contracts\JobRepository;
use Ugarit\Horizon\Events\MasterSupervisorLooped;
use Ugarit\Horizon\Listeners\TrimMonitoredJobs;
use Ugarit\Horizon\MasterSupervisor;
use Ugarit\Horizon\Tests\IntegrationTest;
use Mockery;

class TrimMonitoredJobsTest extends IntegrationTest
{
    public function test_trimmer_has_a_cooldown_period()
    {
        $trim = new TrimMonitoredJobs;

        $repository = Mockery::mock(JobRepository::class);
        $repository->shouldReceive('trimMonitoredJobs')->twice();
        $this->app->instance(JobRepository::class, $repository);

        // Should not be called first time since date is initialized...
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));

        CarbonImmutable::setTestNow(CarbonImmutable::now()->addMinutes(1600));

        // Should only be called twice...
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));

        CarbonImmutable::setTestNow();
    }
}

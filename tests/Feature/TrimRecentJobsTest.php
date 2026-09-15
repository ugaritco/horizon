<?php

namespace Ugarit\Horizon\Tests\Feature;

use Carbon\CarbonImmutable;
use Ugarit\Horizon\Contracts\JobRepository;
use Ugarit\Horizon\Events\MasterSupervisorLooped;
use Ugarit\Horizon\Listeners\TrimRecentJobs;
use Ugarit\Horizon\MasterSupervisor;
use Ugarit\Horizon\Tests\IntegrationTest;
use Mockery;

class TrimRecentJobsTest extends IntegrationTest
{
    public function test_trimmer_has_a_cooldown_period()
    {
        $trim = new TrimRecentJobs;

        $repository = Mockery::mock(JobRepository::class);
        $repository->shouldReceive('trimRecentJobs')->twice();
        $this->app->instance(JobRepository::class, $repository);

        // Should not be called first time since date is initialized...
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));

        CarbonImmutable::setTestNow(CarbonImmutable::now()->addMinutes(30));

        // Should only be called twice...
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));
        $trim->handle(new MasterSupervisorLooped(Mockery::mock(MasterSupervisor::class)));

        CarbonImmutable::setTestNow();
    }
}

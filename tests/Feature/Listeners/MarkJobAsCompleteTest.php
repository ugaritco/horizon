<?php

namespace Ugarit\Horizon\Tests\Feature\Listeners;

use Heritage\Queue\Jobs\RedisJob;
use Ugarit\Horizon\Contracts\JobRepository;
use Ugarit\Horizon\Contracts\Silenced;
use Ugarit\Horizon\Contracts\TagRepository;
use Ugarit\Horizon\Events\JobDeleted;
use Ugarit\Horizon\JobPayload;
use Ugarit\Horizon\Listeners\MarkJobAsComplete;
use Ugarit\Horizon\Tests\IntegrationTest;
use Mockery as m;
use Orchestra\Testbench\Attributes\WithConfig;

#[WithConfig('horizon.silenced', ['App\\Jobs\\ConfigJob'])]
#[WithConfig('horizon.silenced_tags', ['notifications'])]
class MarkJobAsCompleteTest extends IntegrationTest
{
    public function test_it_can_mark_a_job_as_complete(): void
    {
        $this->runScenario('App\\Jobs\\TestJob', false);
    }

    public function test_it_can_handle_silenced_jobs_from_the_config(): void
    {
        $this->runScenario('App\\Jobs\\ConfigJob', true);
    }

    public function test_it_can_handle_silenced_jobs_from_tags(): void
    {
        $this->runScenario('App\\Jobs\\TestJob', true, ['notifications', 'low_priority']);
    }

    public function test_it_can_handle_silenced_jobs_from_an_interface(): void
    {
        $this->runScenario(SilencedJob::class, true);
    }

    public function test_it_can_handle_jobs_which_are_not_silenced(): void
    {
        $this->runScenario(NonSilencedJob::class, false);
    }

    public function runScenario(string $job, bool $silenced, array $jobTags = []): void
    {
        $payload = m::mock(JobPayload::class);
        $payload->shouldReceive('commandName')->andReturn($job);
        $payload->shouldReceive('tags')->andReturn($jobTags);
        $payload->shouldReceive('isSilenced')->andReturn($silenced);

        $job = m::mock(RedisJob::class);
        $job->shouldReceive('hasFailed')->andReturn(false);

        $event = m::mock(JobDeleted::class);
        $event->payload = $payload;
        $event->job = $job;

        $jobs = m::mock(JobRepository::class);
        $jobs->shouldReceive('completed')->once()->with($payload, false, $silenced);

        $tags = m::mock(TagRepository::class);
        $tags->shouldReceive('monitored')->once()->with($jobTags)->andReturn([]);

        $listener = new MarkJobAsComplete($jobs, $tags);

        $listener->handle($event);
    }
}

class SilencedJob implements Silenced
{
}

class NonSilencedJob
{
}

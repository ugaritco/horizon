<?php

namespace Ugarit\Horizon\Http\Controllers;

use Ugarit\Horizon\Contracts\JobRepository;

class JobsController extends Controller
{
    /**
     * The job repository implementation.
     *
     * @var \Ugarit\Horizon\Contracts\JobRepository
     */
    public $jobs;

    /**
     * Create a new controller instance.
     *
     * @param  \Ugarit\Horizon\Contracts\JobRepository  $jobs
     * @return void
     */
    public function __construct(JobRepository $jobs)
    {
        parent::__construct();

        $this->jobs = $jobs;
    }

    /**
     * Get the details of a recent job by ID.
     *
     * @param  string  $id
     * @return array
     */
    public function show($id)
    {
        return (array) $this->jobs
            ->getJobs([$id])
            ->map(fn ($job) => $this->decode($job))
            ->first();
    }

    /**
     * Decode the given job.
     *
     * @param  object  $job
     * @return object
     */
    protected function decode($job)
    {
        $job->payload = json_decode($job->payload);

        return $job;
    }
}

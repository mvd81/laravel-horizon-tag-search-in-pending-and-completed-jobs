<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Horizon\Contracts\JobRepository;
use Laravel\Horizon\Contracts\TagRepository;
use Laravel\Horizon\Http\Controllers\Controller;

class CompletedJobsController extends Controller
{
    /**
     * The job repository implementation.
     *
     * @var \Laravel\Horizon\Contracts\JobRepository
     */
    public $jobs;

    /**
     * The tag repository implementation.
     *
     * @var \Laravel\Horizon\Contracts\TagRepository
     */
    public $tags;

    /**
     * Create a new controller instance.
     *
     * @param  JobRepository  $jobs
     * @param  TagRepository  $tags
     */
    public function __construct(JobRepository $jobs, TagRepository $tags)
    {
        parent::__construct();

        $this->jobs = $jobs;
        $this->tags = $tags;
    }

    /**
     * Get all of the completed jobs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function index(Request $request)
    {
        $jobs = $request->query('tag')
            ? $this->paginateByTag($request, $request->query('tag'))
            : $this->paginate($request);

        $total = $request->query('tag')
            ? $this->tags->count('completed:'.$request->query('tag'))
            : $this->jobs->countCompleted();

        return [
            'jobs' => $jobs,
            'total' => $total,
        ];
    }

    /**
     * Paginate the completed jobs for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    protected function paginate(Request $request)
    {
        return $this->jobs->getCompleted($request->query('starting_at') ?: -1)->map(function ($job) {
            return $this->decode($job);
        });
    }

    /**
     * Paginate the completed jobs for the request and tag.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $tag
     * @return \Illuminate\Support\Collection
     */
    protected function paginateByTag(Request $request, $tag)
    {
        $jobIds = $this->tags->paginate(
            'completed:'.$tag, ($request->query('starting_at') ?: -1) + 1, 50
        );

        $startingAt = $request->query('starting_at', 0);

        return $this->jobs->getJobs($jobIds, $startingAt)->map(function ($job) {
            return $this->decode($job);
        });
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

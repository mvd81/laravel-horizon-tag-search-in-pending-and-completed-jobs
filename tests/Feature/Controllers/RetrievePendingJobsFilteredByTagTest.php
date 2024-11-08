<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\Feature\Controllers;

use Illuminate\Http\Request;
use Laravel\Horizon\Contracts\JobRepository;
use Laravel\Horizon\Contracts\TagRepository;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers\PendingJobsController;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\IntegrationTest;

class RetrievePendingJobsFilteredByTagTest extends IntegrationTest
{
    protected $jobRepository;
    protected $tagRepository;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->jobRepository = $this->createMock(JobRepository::class);
        $this->tagRepository = $this->createMock(TagRepository::class);
    }

    public function test_can_retrieve_pending_jobs_without_tag_search()
    {
        $jobs = collect([
            (object) ['id' => 1, 'payload' => json_encode(['tags' => []])],
            (object) ['id' => 2, 'payload' => json_encode(['tags' => []])],
            (object) ['id' => 3, 'payload' => json_encode(['tags' => ['tag 1']])],
        ]);

        $this->jobRepository->method('getPending')->willReturn($jobs);
        $this->jobRepository->method('countPending')->willReturn(3);

        $controller = new PendingJobsController($this->jobRepository, $this->tagRepository);
        $request = Request::create('/api/pending-jobs', 'GET');

        $response = $controller->index($request);

        $this->assertCount(3, $response['jobs']);
        $this->assertEquals(3, $response['total']);
    }

    public function test_can_retrieve_pending_jobs_with_tag_search()
    {
        $tag = 'developer';
        $jobs = collect([
            (object) ['id' => 1093, 'status' => 'pending', 'payload' => json_encode(['tags' => [$tag]])],
            (object) ['id' => 2839, 'status' => 'completed', 'payload' => json_encode(['tags' => [$tag]])],
            (object) ['id' => 2839, 'status' => 'pending', 'payload' => json_encode(['tags' => [$tag]])],
        ]);

        $this->tagRepository->method('paginate')->willReturn([$jobs[0]->id, $jobs[2]->id]);
        $this->tagRepository->method('count')->willReturn(2);
        $this->jobRepository->method('getJobs')->willReturn($jobs->where('status', 'pending'));

        $controller = new PendingJobsController($this->jobRepository, $this->tagRepository);
        $request = Request::create('/api/pending-jobs', 'GET', ['tag' => $tag]);

        $response = $controller->index($request);

        $this->assertCount(2, $response['jobs']);
        $this->assertEquals(2, $response['total']);
        $this->assertEquals('pending', $response['jobs'][2]->status);
    }
}

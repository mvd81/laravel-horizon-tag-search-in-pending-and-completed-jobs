<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\Feature\Controllers;

use Illuminate\Http\Request;
use Laravel\Horizon\Contracts\JobRepository;
use Laravel\Horizon\Contracts\TagRepository;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers\CompletedJobsController;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\IntegrationTest;

class RetrieveCompletedJobsFilteredByTagTest extends IntegrationTest
{
    protected $jobRepository;

    private $tagRepository;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->jobRepository = $this->createMock(JobRepository::class);
        $this->tagRepository = $this->createMock(TagRepository::class);
    }

    public function test_can_retrieve_completed_jobs_without_tag_search()
    {
        $jobs = collect([
            (object) ['id' => 1, 'payload' => json_encode(['tags' => []])],
            (object) ['id' => 2, 'payload' => json_encode(['tags' => []])],
            (object) ['id' => 3, 'payload' => json_encode(['tags' => ['tag A']])],
            (object) ['id' => 4, 'payload' => json_encode(['tags' => []])],
        ]);

        $this->jobRepository->method('getCompleted')->willReturn($jobs);
        $this->jobRepository->method('countCompleted')->willReturn(4);

        $controller = new CompletedJobsController($this->jobRepository, $this->tagRepository);
        $request = Request::create('/api/jobs', 'GET');

        $response = $controller->index($request);

        $this->assertCount(4, $response['jobs']);
        $this->assertEquals(4, $response['total']);
    }

    public function test_can_retrieve_completed_jobs_with_tag_search()
    {
        $tag = 'foobar';
        $jobs = collect([
            (object) ['id' => 3838, 'status' => 'completed', 'payload' => json_encode(['tags' => [$tag]])],
            (object) ['id' => 3838, 'status' => 'pending', 'payload' => json_encode(['tags' => [$tag]])],
            (object) ['id' => 9933, 'status' => 'completed', 'payload' => json_encode(['tags' => [$tag]])],
        ]);

        $this->tagRepository->method('paginate')->willReturn([$jobs[0]->id, $jobs[2]->id]);
        $this->tagRepository->method('count')->willReturn(2);
        $this->jobRepository->method('getJobs')->willReturn($jobs->where('status', 'completed'));

        $controller = new CompletedJobsController($this->jobRepository, $this->tagRepository);
        $request = Request::create('/api/jobs', 'GET', ['tag' => $tag]);

        $response = $controller->index($request);

        $this->assertCount(2, $response['jobs']);
        $this->assertEquals(2, $response['total']);
        $this->assertEquals('completed', $response['jobs'][2]->status);
    }
}

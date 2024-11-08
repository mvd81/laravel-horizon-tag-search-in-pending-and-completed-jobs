<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\Feature\Listeners;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Queue\Jobs\Job;
use Laravel\Horizon\Contracts\TagRepository;
use Laravel\Horizon\Events\JobDeleted;
use Mockery as m;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\IntegrationTest;

class ForgetPendingTagsForCompletedJobTest extends IntegrationTest
{
    protected function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function test_if_pending_tags_are_removed_when_a_job_is_completed(): void
    {
        $tagRepository = m::mock(TagRepository::class);

        $tagRepository->shouldReceive('monitored')->once()->andReturn([]);
        $tagRepository->shouldReceive('addTemporary')->once()->andReturn([]);

        $tagRepository->shouldReceive('forgetJobs')->once()
            ->with(['pending:foobar', 'pending:bar'], '1')
            ->andReturn([]);

        $this->instance(TagRepository::class, $tagRepository);

        $event = new JobDeleted(
            new PendingJob(),
            json_encode([
                'id' => '1',
                'displayName' => 'displayName',
                'tags' => ['foobar', 'bar'],
            ])
        );

        $this->app->make(Dispatcher::class)->dispatch($event);
    }
}

class PendingJob extends Job
{
    public function getJobId()
    {
        return '1';
    }

    public function getRawBody()
    {
        return '';
    }
}

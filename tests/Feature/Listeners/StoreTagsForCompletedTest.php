<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\Feature\Listeners;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Queue\Jobs\Job;
use Laravel\Horizon\Contracts\TagRepository;
use Laravel\Horizon\Events\JobDeleted;
use Mockery as m;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\IntegrationTest;

class StoreTagsForCompletedTest extends IntegrationTest
{
    protected function tearDown(): void
    {
        parent::tearDown();

        m::close();
    }

    public function test_completed_tag_is_added_when_job_completes(): void
    {
        config()->set('horizon.trim.completed', 120);

        $tagRepository = m::mock(TagRepository::class);

        $tagRepository->shouldReceive('addTemporary')->once()->with(120, '1', ['completed:foobar'])->andReturn([]);
        $tagRepository->shouldReceive('monitored')->once()->andReturn([]);
        $tagRepository->shouldReceive('forgetJobs')->once()->andReturn([]);

        $this->instance(TagRepository::class, $tagRepository);

        $this->app->make(Dispatcher::class)->dispatch(new JobDeleted(
            new CompletedJob(), '{"id":"1","displayName":"displayName","tags":["foobar"]}'
        ));
    }
}

class CompletedJob extends Job
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

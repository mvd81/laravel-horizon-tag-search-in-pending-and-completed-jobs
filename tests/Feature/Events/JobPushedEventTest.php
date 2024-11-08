<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\Feature\Events;

use Illuminate\Support\Facades\Event;
use Laravel\Horizon\Events\JobPushed;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\StoreTagsForPendingJob;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\IntegrationTest;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Providers\EventServiceProvider;

class JobPushedEventTest extends IntegrationTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(EventServiceProvider::class);
    }

    /** @test */
    public function test_triggers_the_listener_on_job_pushed_event()
    {
        Event::fake();

        Event::assertListening(
            JobPushed::class,
            StoreTagsForPendingJob::class
        );
    }
}
<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\Feature\Events;

use Illuminate\Support\Facades\Event;
use Laravel\Horizon\Events\JobDeleted;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\ForgetJobInPendingTags;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\StoreTagsForCompletedJob;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\IntegrationTest;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Providers\EventServiceProvider;

class JobDeletedEventTest extends IntegrationTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(EventServiceProvider::class);
    }

    /** @test */
    public function test_triggers_the_listeners_on_job_deleted_event()
    {
        Event::fake();

        Event::assertListening(
            JobDeleted::class,
            ForgetJobInPendingTags::class
        );

        Event::assertListening(
            JobDeleted::class,
            StoreTagsForCompletedJob::class
        );
    }
}
<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\Feature\Events;

use Illuminate\Support\Facades\Event;
use Laravel\Horizon\Events\JobDeleted;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\ForgetJobInPendingTags;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\StoreTagsForCompletedJob;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\IntegrationTest;

class JobDeletedEventTest extends IntegrationTest
{
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
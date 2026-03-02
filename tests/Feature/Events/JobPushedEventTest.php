<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\Feature\Events;

use Illuminate\Support\Facades\Event;
use Laravel\Horizon\Events\JobPushed;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\StoreTagsForPendingJob;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Tests\IntegrationTest;

class JobPushedEventTest extends IntegrationTest
{
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
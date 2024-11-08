<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Horizon\Events\JobDeleted;
use Laravel\Horizon\Events\JobPushed;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\ForgetJobInPendingTags;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\StoreTagsForCompletedJob;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\StoreTagsForPendingJob;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        JobPushed::class => [
            StoreTagsForPendingJob::class
        ],
        JobDeleted::class => [
            ForgetJobInPendingTags::class,
            StoreTagsForCompletedJob::class
        ],

    ];

    public function boot()
    {
        parent::boot();
    }
}
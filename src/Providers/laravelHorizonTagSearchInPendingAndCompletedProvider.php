<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Events\JobDeleted;
use Laravel\Horizon\Events\JobPushed;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\ForgetJobInPendingTags;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\StoreTagsForCompletedJob;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners\StoreTagsForPendingJob;

class laravelHorizonTagSearchInPendingAndCompletedProvider extends ServiceProvider {

    public function boot() {

        Event::listen(JobPushed::class, StoreTagsForPendingJob::class);
        Event::listen(JobDeleted::class, ForgetJobInPendingTags::class);
        Event::listen(JobDeleted::class, StoreTagsForCompletedJob::class);

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'custom-horizon');
    }
}

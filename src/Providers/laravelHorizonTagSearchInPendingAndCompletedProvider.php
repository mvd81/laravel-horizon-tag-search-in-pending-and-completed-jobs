<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Providers;

use Illuminate\Support\ServiceProvider;

class laravelHorizonTagSearchInPendingAndCompletedProvider extends ServiceProvider {

    public function register()
    {
        $this->app->register(EventServiceProvider::class);
    }

    public function boot() {

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'custom-horizon');
    }
}
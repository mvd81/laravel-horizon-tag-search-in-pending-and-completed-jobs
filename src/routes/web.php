<?php

use Illuminate\Support\Facades\Route;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers\CompletedJobsController;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers\CustomHomeController;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers\PendingJobsController;

Route::middleware(['web'])
    ->namespace($this->app->getNamespace().'Http\Controllers')
    ->group(function () {
        Route::get('/horizon/{view?}', [CustomHomeController::class, 'index'])
            ->where('view', '(.*)')
            ->name('horizon.index');
    });

Route::namespace('mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers')
    ->domain(config('horizon.domain', null))
    ->prefix(config('horizon.path'))
    ->group(function () {

        Route::get('/jobs/pending', [PendingJobsController::class, 'index'])
            ->name('horizon.pending-jobs.index');

        Route::get('/jobs/completed', [CompletedJobsController::class, 'index'])
            ->name('horizon.completed-jobs.index');
    });

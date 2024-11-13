<?php

use Illuminate\Support\Facades\Route;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers\CompletedJobsController;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers\CustomHomeController;
use mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers\PendingJobsController;

Route::namespace('mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Http\Controllers')
    ->domain(config('horizon.domain', null))
    ->prefix(config('horizon.path'))
    ->middleware(config('horizon.middleware', 'web'))
    ->group(function () {

        Route::get('/{view?}', [CustomHomeController::class, 'index'])
            ->where('view', '(.*)')
            ->name('horizon.index');

        Route::prefix('api')->group(function () {

            Route::get('/jobs/pending', [PendingJobsController::class, 'index'])
                ->name('horizon.pending-jobs.index');

            Route::get('/jobs/completed', [CompletedJobsController::class, 'index'])
                ->name('horizon.completed-jobs.index');
        });
    });

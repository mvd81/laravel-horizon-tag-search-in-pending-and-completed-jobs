<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners;

use Laravel\Horizon\Contracts\TagRepository;
use Laravel\Horizon\Events\JobDeleted;

class StoreTagsForCompletedJob
{
    /**
     * The tag repository implementation.
     *
     * @var \Laravel\Horizon\Contracts\TagRepository
     */
    public $tags;

    /**
     * Create a new listener instance.
     *
     * @param  \Laravel\Horizon\Contracts\TagRepository  $tags
     * @return void
     */
    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Handle the event.
     *
     * @param  \Laravel\Horizon\Events\JobDeleted  $event
     * @return void
     */
    public function handle(JobDeleted $event): void
    {
        if ($event->job->hasFailed()) {
            return;
        }

        $tags = collect($event->payload->tags())->map(function ($tag) {
            return 'completed:'.$tag;
        })->all();

        if (! empty($tags)) {
            $this->tags->addTemporary(
                config('horizon.trim.completed', 2880), $event->payload->id(), $tags
            );
        }
    }
}

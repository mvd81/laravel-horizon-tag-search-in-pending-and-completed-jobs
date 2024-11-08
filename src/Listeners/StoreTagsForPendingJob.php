<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners;

use Laravel\Horizon\Contracts\TagRepository;
use Laravel\Horizon\Events\JobPushed;

class StoreTagsForPendingJob
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
     * @param  \Laravel\Horizon\Events\JobPushed  $event
     * @return void
     */
    public function handle(JobPushed $event)
    {
        $tags = collect($event->payload->tags())->map(function ($tag) {
            return 'pending:'.$tag;
        })->all();

        // Only create tags if there are tags in the job payload.
        if (! empty($tags)) {
            $this->tags->addTemporary(
                config('horizon.trim.pending', 2880), $event->payload->id(), $tags
            );
        }
    }
}

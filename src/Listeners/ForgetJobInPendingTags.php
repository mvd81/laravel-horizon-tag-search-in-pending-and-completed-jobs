<?php

namespace mvd81\laravelHorizonTagSearchInPendingAndCompletedJobs\Listeners;

use Laravel\Horizon\Contracts\TagRepository;
use Laravel\Horizon\Events\JobDeleted;

class ForgetJobInPendingTags
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
        $pendingTags = collect($event->payload->tags())->map(function ($tag) {
            return 'pending:'.$tag;
        })->all();

        if (! empty($pendingTags)) {
            $this->tags->forgetJobs($pendingTags, $event->payload->id());
        }
    }
}

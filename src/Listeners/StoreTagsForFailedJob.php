<?php

namespace Ugarit\Horizon\Listeners;

use Ugarit\Horizon\Contracts\TagRepository;
use Ugarit\Horizon\Events\JobFailed;

class StoreTagsForFailedJob
{
    /**
     * The tag repository implementation.
     *
     * @var \Ugarit\Horizon\Contracts\TagRepository
     */
    public $tags;

    /**
     * Create a new listener instance.
     *
     * @param  \Ugarit\Horizon\Contracts\TagRepository  $tags
     * @return void
     */
    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Handle the event.
     *
     * @param  \Ugarit\Horizon\Events\JobFailed  $event
     * @return void
     */
    public function handle(JobFailed $event)
    {
        $tags = collect($event->payload->tags())
            ->map(fn ($tag) => 'failed:'.$tag)
            ->all();

        $this->tags->addTemporary(
            config('horizon.trim.failed', 2880), $event->payload->id(), $tags
        );
    }
}

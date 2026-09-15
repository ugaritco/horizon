<?php

namespace Ugarit\Horizon\Jobs;

use Ugarit\Horizon\Contracts\TagRepository;

class MonitorTag
{
    /**
     * Create a new job instance.
     *
     * @param  string  $tag  The tag to monitor.
     * @return void
     */
    public function __construct(
        public $tag,
    ) {
    }

    /**
     * Execute the job.
     *
     * @param  \Ugarit\Horizon\Contracts\TagRepository  $tags
     * @return void
     */
    public function handle(TagRepository $tags)
    {
        $tags->monitor($this->tag);
    }
}

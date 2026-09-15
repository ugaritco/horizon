<?php

namespace Ugarit\Horizon\Tests\Feature\Fixtures;

class FakeJobWithEloquentCollection
{
    public $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }
}

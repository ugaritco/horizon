<?php

namespace Ugarit\Horizon\Tests\Feature\Commands;

use Ugarit\Horizon\Supervisor;

class FakeCommand
{
    public $processCount = 0;
    public $supervisor;
    public $options;

    public function process(Supervisor $supervisor, array $options)
    {
        $this->processCount++;
        $this->supervisor = $supervisor;
        $this->options = $options;
    }
}

<?php

namespace Ugarit\Horizon\Tests\Feature\Fixtures;

use Heritage\Contracts\Events\Dispatcher;

class FakeListenerWithProperties
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @var FakeEventWithModel
     */
    protected $fakeModel;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(FakeEventWithModel $fakeEventWithModel): void
    {
        $this->fakeModel = $fakeEventWithModel->model;
    }
}

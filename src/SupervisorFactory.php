<?php

namespace Ugarit\Horizon;

class SupervisorFactory
{
    /**
     * Create a new supervisor instance.
     *
     * @param  \Ugarit\Horizon\SupervisorOptions  $options
     * @return \Ugarit\Horizon\Supervisor
     */
    public function make(SupervisorOptions $options)
    {
        return new Supervisor($options);
    }
}

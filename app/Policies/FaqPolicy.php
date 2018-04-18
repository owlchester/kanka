<?php

namespace App\Policies;

use TCG\Voyager\Contracts\User;
use TCG\Voyager\Policies\BasePolicy;

class FaqPolicy extends BasePolicy
{
    /**
     * Handle all requested permission checks.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return bool
     */
    public function __call($name, $arguments)
    {
        if (count($arguments) < 2) {
            throw new \InvalidArgumentException('not enough arguments');
        }

        return true;
    }
}

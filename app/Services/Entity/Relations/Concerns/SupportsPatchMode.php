<?php

namespace App\Services\Entity\Relations\Concerns;

trait SupportsPatchMode
{
    protected bool $isPatch = false;

    public function patch(): static
    {
        $this->isPatch = true;

        return $this;
    }
}

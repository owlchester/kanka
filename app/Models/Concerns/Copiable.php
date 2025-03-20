<?php

namespace App\Models\Concerns;

trait Copiable
{
    public function isCopiableObject(): bool
    {
        return true;
    }
}

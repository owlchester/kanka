<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 * Trait for request aware services
 */
trait RequestAware
{
    public ?Request $request;

    public function request(Request $request): self
    {
        $this->request = $request;

        return $this;
    }
}

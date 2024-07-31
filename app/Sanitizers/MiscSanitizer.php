<?php

namespace App\Sanitizers;

use App\Observers\PurifiableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MiscSanitizer
{
    use PurifiableTrait;

    protected Request $request;

    protected array $data = [];

    public function request(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function sanitize(): array
    {
        return $this->data;
    }
}

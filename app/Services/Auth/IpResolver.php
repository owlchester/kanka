<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;

class IpResolver
{
    public function __construct(protected Request $request) {}

    public function resolve(): string
    {
        $cf = $this->request->server('HTTP_CF_CONNECTING_IP');

        return ! empty($cf) ? $cf : ($this->request->ip() ?? '');
    }
}

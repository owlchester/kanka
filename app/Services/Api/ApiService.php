<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\DB;

class ApiService implements \JsonSerializable
{
    public function jsonSerialize(): mixed
    {
        return count(DB::getQueryLog());
    }
}

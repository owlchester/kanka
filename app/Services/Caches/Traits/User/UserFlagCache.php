<?php

namespace App\Services\Caches\Traits\User;

use Illuminate\Support\Collection;

trait UserFlagCache
{
    public function flags(): Collection
    {
        return new Collection(
            $this->primary($this->activeUser()->id)->get('flags')
        );
    }
}

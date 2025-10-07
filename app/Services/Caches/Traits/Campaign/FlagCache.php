<?php

namespace App\Services\Caches\Traits\Campaign;

use Illuminate\Support\Collection;

trait FlagCache
{
    public function flags(): Collection
    {
        return new Collection($this->primary($this->campaign->id)->get('flags'));
    }

    protected function formatFlags(): array
    {
        $flags = [];
        foreach ($this->campaign->flags as $flag) {
            $flags[$flag->flag->value] = $flag->value;
        }

        return $flags;
    }
}

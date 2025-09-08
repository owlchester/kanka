<?php

namespace App\Traits\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

trait HasNested
{
    public function saveNested(string $key): bool
    {
        $new = (bool) $this->request->get('n');
        if (auth()->guest()) {
            Session::put($key, $new);
        } else {
            $settings = auth()->user()->settings;
            if (auth()->check() && Arr::get($settings, $key) !== $new) {
                $settings = auth()->user()->settings;
                if ($new) {
                    unset($settings[$key]);
                } else {
                    $settings[$key] = false;
                }
                auth()->user()->settings = $settings;
                auth()->user()->updateQuietly();
            }
        }
        return $new;
    }
}

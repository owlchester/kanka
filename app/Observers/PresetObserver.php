<?php

namespace App\Observers;

use App\Models\Preset;

class PresetObserver
{
    use PurifiableTrait;

    public function saving(Preset $preset)
    {
        // Clean up config
        $config = $preset->config;
        foreach ($config as $key => $value) {
            if ($value === null) {
                unset($config[$key]);
            }
        }

        $preset->config = $config;
    }
}

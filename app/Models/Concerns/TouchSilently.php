<?php

namespace App\Models\Concerns;

trait TouchSilently
{
    /**
     * Touch a model (update the timestamps) without any observers/events
     */
    public function touchSilently()
    {
        return static::withoutEvents(function () {
            if (in_array('updated_by', $this->getFillable())) {
                // Still log who edited the entity
                $this->updated_by = auth()->user()->id;
            }

            return $this->touch();
        });
    }
}

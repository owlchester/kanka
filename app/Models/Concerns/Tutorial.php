<?php

namespace App\Models\Concerns;

use Carbon\Carbon;

/**
 *
 * @property array $tutorial
 */
trait Tutorial
{
    /**
     * Set a tutorial key as done
     * @param string $key
     * @return $this
     */
    public function doneTutorial(string $key): self
    {
        if (empty($key)) {
            return $this;
        }
        $tutorial = $this->tutorial;
        $tutorial[$key] = Carbon::now();
        $this->tutorial = $tutorial;
        //$this->save();

        return $this;
    }

    /**
     * Check if a tutorial was read
     * @param string $key
     * @return bool
     */
    public function readTutorial(string $key): bool
    {
        return isset($this->tutorial[$key]);
    }

    /**
     * Reset a tutorial key
     */
    public function resetTutorial(string $key = null): self
    {
        $tutorial = $this->tutorial;
        if (empty($key)) {
            $tutorial = [];
        } else {
            unset($tutorial[$key]);
        }
        $this->tutorial = $tutorial;
        $this->save();

        return $this;
    }

    /**
     * Check if the user has disabled tutorials completely
     * @return bool
     */
    public function disabledTutorial(): bool
    {
        return true;
        return isset($this->tutorial['disabled']);
    }

}

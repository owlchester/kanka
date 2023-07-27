<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;

class UserDateService
{
    /**
     * Default format is MMMM d, Y
     * @var string
     */
    private string $format = 'LL';

    /**
     * Display a date to the user's preferred format
     * @param string|null $date
     * @return string
     */
    public function format(string $date = null): string
    {
        if (empty($date)) {
            return '';
        }
        $this->loadUserFormat();
        try {
            $original = new Carbon($date);
            return $original->isoFormat($this->format);
        } catch (Exception $e) {
            return (string) $date;
        }
    }

    /**
     * Load the user's format if logged in
     * @return void
     */
    private function loadUserFormat(): void
    {
        // Get the user's date format if they have a custom one
        if (auth()->guest() || empty(auth()->user()->dateformat)) {
            return;
        }
        $this->format = mb_strtoupper(auth()->user()->dateformat);
        $this->format = str_replace('M', 'MM', $this->format);
    }
}

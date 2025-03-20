<?php

namespace App\Services\Users;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;

class DateService
{
    /**
     * Default format is MMMM d, Y
     */
    private string $format = 'LL';

    /**
     * Display a date to the user's preferred format
     */
    public function format(?string $date = null): string
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
     */
    private function loadUserFormat(): void
    {
        // Get the user's date format if they have a custom one
        if (auth()->guest() || empty(auth()->user()->dateformat)) {
            return;
        }
        $this->format = mb_strtoupper(auth()->user()->dateformat);
        $this->format = Str::replace(['M', 'D'], ['MM', 'DD'], $this->format);
    }
}

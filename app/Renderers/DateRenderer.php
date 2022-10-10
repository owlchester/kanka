<?php

namespace App\Renderers;

use Illuminate\Support\Str;

class DateRenderer
{
    protected string $format = 'y-m-d';

    protected string $delimiter = '-';

    public function render(string $date = null): string
    {
        if (auth()->check()) {
            $this->format = strtolower(auth()->user()->date_format);
        }

        $original = explode('-', $date);
        if (Str::startsWith($date, '-')) {
            $original = explode('-', ltrim($date, '-'));
            $original[0] = '-' . $original[0];
        }

        $this->delimiter = $this->format[1];

        // @phpstan-ignore-next-line
        $to = explode($this->delimiter, $this->format);

        try {
            // Build the new value
            return $this->addSegment($original, $to[0]) .
                $this->addSegment($original, $to[1]) .
                $this->addSegment($original, $to[2], false);
        } catch (\Exception $e) {
            return (string) $date;
        }
    }

    /**
     * @param array $date
     * @param string $segment
     * @param bool $addDelimiter
     * @return string
     */
    protected function addSegment(array $date, string $segment, bool $addDelimiter = true)
    {
        $value = null;
        if ($segment == 'y') {
            $value = $date[0];
        } elseif ($segment == 'm') {
            $value = $date[1];
        } else {
            $value = $date[2];
        }
        return $value . ($addDelimiter ? $this->delimiter : null);
    }
}

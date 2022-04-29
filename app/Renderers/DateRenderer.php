<?php

namespace App\Renderers;

use Illuminate\Support\Str;

class DateRenderer
{
    /**
     * @var string
     */
    protected $format = 'y-m-d';

    protected $delimiter = '-';

    public function render($date): string
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
     * @param $date
     * @param $segment
     * @return string
     */
    protected function addSegment($date, $segment, $addDelimiter = true)
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

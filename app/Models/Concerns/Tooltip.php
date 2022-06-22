<?php

namespace App\Models\Concerns;

use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait Tooltip
{
    /**
     * Wrapper for short entry
     * @return mixed
     */
    public function tooltip($limit = 250, $stripSpecial = true)
    {
        // Replace return chars to space to avoid "text blabla.New sentence"
        $pureHistory = str_replace('<br\s*/*>', " ", $this->{$this->tooltipField});

        // Always remove tags. ALWAYS.
        $pureHistory = strip_tags($pureHistory);

        if ($stripSpecial) {
            // Remove double quotes because they are the spawn of the devil.
            $pureHistory = str_replace('"', '\'', $pureHistory);
            $pureHistory = str_replace('&quot;', '\'', $pureHistory);

            // Remove any leftover < and > for sanity's sake
            $pureHistory = str_replace('&gt;', null, $pureHistory);
            $pureHistory = str_replace('&lt;', null, $pureHistory);
            //$pureHistory = htmlentities(htmlspecialchars($pureHistory));
        }

        $pureHistory = preg_replace("/\s/ui", ' ', $pureHistory);
        $pureHistory = trim($pureHistory);

        if (!empty($pureHistory)) {
            if (strlen($pureHistory) > $limit) {
                return mb_substr($pureHistory, 0, $limit) . '...';
            }
        }
        return $pureHistory;
    }
}

<?php

namespace App\Services\Campaign\Import;

use App\Facades\ImportIdMapper;
use Illuminate\Support\Str;

trait ImportMentions
{
    protected function mentions(string|null $text): string|null
    {
        if (empty($text)) {
            return $text;
        }

        return preg_replace_callback(
            '`\[([a-z_]+):(.*?)\]`i',
            function ($matches) {
                $segments = explode('|', $matches[2]);
                $oldEntityID = (int) $segments[0];
                $entityType = $matches[1];

                if (!ImportIdMapper::hasEntity($oldEntityID)) {
                    return $matches[0];
                }
                $entityID = ImportIdMapper::getEntity($oldEntityID);

                if (Str::contains($matches[2], '|')) {
                    return '[' . $entityType . ':' . Str::replace($oldEntityID . '|', $entityID . '|', $matches[2]);
                }
                return '[' . $entityType . ':' . $entityID . ']';
            },
            $text
        );
    }
}

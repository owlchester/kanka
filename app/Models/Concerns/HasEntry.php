<?php

namespace App\Models\Concerns;

use App\Facades\Mentions;
use App\Observers\EntryObserver;

/**
 *
 * @property ?string $entry
 * @property ?int $words
 */
trait HasEntry
{
    public static function bootHasEntry(): void
    {
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }
        static::observe(app(EntryObserver::class));
    }

    public function entryFieldName(): string
    {
        return $this->entryField ?? 'entry';
    }

    public function tooltipFieldName(): string
    {
        return $this->tooltipField ?? 'tooltip';
    }

    /**
     * Get the entry where mentions are parsed to html links
     */
    public function parsedEntry(): string
    {
        return Mentions::mapAny($this, $this->entryFieldName());
    }

    /**
     * Get the entry where mentions are made to look nice for the text editor
     */
    public function getEntryForEditionAttribute(): string
    {
        return Mentions::parseForEdit($this, $this->entryFieldName());
    }

    /**
     * Determine if the marker has a filled out entry
     */
    public function hasEntry(): bool
    {
        // If all that's in the entry is two \n, then there is no real content
        $stripped = mb_trim(preg_replace('/\s\s+/', ' ', $this->{$this->entryFieldName()}));
        return !empty($stripped);
    }
}

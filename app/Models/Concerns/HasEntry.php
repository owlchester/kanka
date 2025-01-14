<?php

namespace App\Models\Concerns;

use App\Facades\Mentions;
use App\Observers\EntryObserver;

/**
 *
 * @property ?string $entry
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
}

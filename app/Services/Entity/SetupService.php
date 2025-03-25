<?php

namespace App\Services\Entity;

use Illuminate\Support\Str;

class SetupService
{
    /**
     * Get the icon associated to an entity type. Later one, we can
     * hook the campaign sidebar config to get the icon instead.
     */
    public function icon(int $type): string
    {
        switch ($type) {
            case 1: // character
                return 'fa-solid fa-user';
            case 2: // family
                return 'ra ra-double-team';
            case 3: // location
                return 'ra ra-tower';
            case 4: // org
                return 'ra ra ra-hood';
            case 5: // item
                return 'ra ra-gem-pendant';
            case 6: // note
                return 'fa-solid fa-book-open';
            case 7: // event
                return 'fa-solid fa-bolt';
            case 8: // calendar
                return 'fa-solid fa-calendar';
            case 9: // race
                return 'ra ra ra-wyvern';
            case 10: // quest
                return 'ra ra-wooden-sign';
            case 11: // journal
                return 'ra ra-quill-ink';
            case 12: // tag
                return 'fa-solid fa-tags';
            case 13: // dice role
                return 'ra ra-dice-five';
            case 14: // conversation
                return 'fa-solid fa-comment';
            case 15: // attr template
                return 'fa-solid fa-copy';
            case 16: // ability
                return 'ra ra-fire-symbol';
            case 17: // map
                return 'fa-solid fa-map';
            case 18: // timeline
                return 'fa-solid fa-hourglass-half';
            case 19: // bookmark
                return 'fa-solid fa-star';
            case 20: // creature
                return 'ra ra-raven';
            default: // fallback, visual cue that we're doing something wrong
                return 'fa-solid fa-question-circle';
        }
    }

    /**
     * Get the plural name of an entity
     */
    public function plural(int $entity): string
    {
        $type = array_search($entity, config('entities.ids'));
        if ($type) {
            $type = Str::plural($type);

            return __('entities.' . $type);
        }

        return __('Unknown');
    }

    /**
     * Get the singular name of an entity
     */
    public function singular(int $entity): string
    {
        $type = array_search($entity, config('entities.ids'));
        if ($type) {
            return __('entities.' . $type);
        }

        return __('Unknown');
    }
}

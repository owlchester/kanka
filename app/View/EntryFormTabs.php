<?php

namespace App\View;

use App\Facades\Module;
use App\Models\Campaign;
use App\Models\EntityType;

class EntryFormTabs
{
    public static function for(EntityType $type, Campaign $campaign, bool $modern = false): array
    {
        if ($type->isCharacter()) {
            $tabs = $modern ? [] : ['traits' => __('characters.fields.traits')];
            if ($campaign->enabled('organisations')) {
                $tabs['organisations'] = Module::plural(config('entities.ids.organisation'), __('entities.organisations'));
            }

            return $tabs;
        }

        return match (true) {
            $type->isStandardCode('event') => ['participants' => __('events.participants.title')],
            $type->isMap() => ['settings' => __('maps.panels.settings')],
            $type->isStandardCode('calendar') => [
                'calendar' => __('entries/workspace.settings'),
                'eras' => __('calendars.panels.eras'),
                'months' => __('calendars.panels.months'),
                'weeks' => __('calendars.panels.weeks'),
                'moons' => __('calendars.fields.moons'),
                'seasons' => __('calendars.fields.seasons'),
            ],
            default => [],
        };
    }
}

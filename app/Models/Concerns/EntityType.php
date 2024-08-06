<?php

namespace App\Models\Concerns;

/**
 * @property ?int $type_id
 */
trait EntityType
{
    public function isCharacter(): bool
    {
        return $this->type_id === config('entities.ids.character');
    }

    public function isLocation(): bool
    {
        return $this->type_id === config('entities.ids.location');
    }

    public function isFamily(): bool
    {
        return $this->type_id === config('entities.ids.family');
    }

    public function isMap(): bool
    {
        return $this->type_id === config('entities.ids.map');
    }

    public function isQuest(): bool
    {
        return $this->type_id === config('entities.ids.quest');
    }

    public function isTimeline(): bool
    {
        return $this->type_id === config('entities.ids.timeline');
    }

    public function isDiceRoll(): bool
    {
        return $this->type_id === config('entities.ids.dice_roll');
    }

    public function isAttributeTemplate(): bool
    {
        return $this->type_id === config('entities.ids.attribute_template');
    }

    public function isTag(): bool
    {
        return $this->type_id === config('entities.ids.tag');
    }
}

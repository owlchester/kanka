<?php

namespace App\Services\Abilities;

use App\Models\Character;
use App\Models\EntityAbility;
use App\Traits\EntityAware;
use Exception;

class ImportService
{
    use EntityAware;

    /**
     * @throws Exception
     */
    public function import(): int
    {
        if (! $this->entity->isCharacter()) {
            throw new Exception('not_character');
        }
        /** @var Character $character */
        $character = $this->entity->child;
        if (empty($character->characterRaces)) {
            throw new Exception('no_race');
        }
        $count = 0;

        // Existing abilities
        $abilities = $this->entity->abilities()->with('ability')->get();
        $existingIds = [];
        foreach ($abilities as $ability) {
            // The ability is soft deleted so we can skip it
            if (empty($ability) || empty($ability->ability)) {
                continue;
            }
            $existingIds[] = $ability->ability_id;
        }

        foreach ($character->characterRaces()->with('race', 'race.entity', 'race.entity.abilities')->get() as $race) {
            /** @var EntityAbility[] $abilities */
            $abilities = $race->race->entity->abilities;
            $count = 0;
            foreach ($abilities as $ability) {
                // If it's deleted or already on this entity, skip
                if (empty($ability->ability) || in_array($ability->ability_id, $existingIds)) {
                    continue;
                }
                $new = $ability->replicate(['entity_id']);
                $new->entity_id = $this->entity->id;
                $new->save();
                $count++;
            }
        }

        return $count;
    }
}

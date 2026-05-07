<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\ImportIdMapper;
use App\Models\Character;
use App\Models\CharacterOrganisation;
use App\Models\CharacterTrait;
use Illuminate\Support\Arr;

class CharacterMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'created_at', 'location_id', 'updated_at', 'race_id', 'family_id'];

    protected string $className = Character::class;

    protected string $mappingName = 'characters';

    public function first(): void
    {
        $this
            ->migrateOldStatus()
            ->prepareModel()
            ->trackMappings('character_id');
    }

    /**
     * Backward compatibility: resolve old character status fields to entities.status_id.
     * Old is_dead boolean or child status_id enum (0=alive, 1=dead, 2=missing).
     */
    protected function migrateOldStatus(): self
    {
        if (array_key_exists('status_id', $this->data['entity'] ?? [])) {
            return $this;
        }

        $map = [0 => 'alive', 1 => 'dead', 2 => 'missing'];

        // Old is_dead boolean → enum value
        if (array_key_exists('is_dead', $this->data) && ! array_key_exists('status_id', $this->data)) {
            $this->data['status_id'] = (int) $this->data['is_dead'];
            unset($this->data['is_dead']);
        }

        // Child-level status_id enum → resolve to category_statuses, then remove
        // so it doesn't get written back to the characters table's old enum column
        if (array_key_exists('status_id', $this->data)) {
            $oldValue = (int) $this->data['status_id'];
            unset($this->data['status_id']);
            if (isset($map[$oldValue])) {
                $this->resolveOldStatusToEntity('character', $map[$oldValue]);
            }
        }

        return $this;
    }

    public function second(): void
    {
        // @phpstan-ignore-next-line
        $this
            ->loadModel()
            ->pivot('characterFamilies', 'families', 'family_id')
            ->pivot('characterRaces', 'races', 'race_id')
            ->saveModel()
            ->traits()
            ->characterLocations()
            ->memberships()
            ->entitySecond();
    }

    protected function traits(): self
    {
        if (empty($this->data['characterTraits'])) {
            return $this;
        }
        $fields = ['name', 'entry', 'is_private', 'section_id', 'default_order'];
        foreach ($this->data['characterTraits'] as $data) {
            $trait = new CharacterTrait;
            $trait->character_id = $this->model->id;
            foreach ($fields as $field) {
                if (! array_key_exists($field, $data)) {
                    continue;
                }
                $trait->$field = $data[$field];
            }
            $trait->save();
        }

        return $this;
    }

    protected function memberships(): self
    {
        if (empty($this->data['organisationMemberships'])) {
            return $this;
        }
        $parents = [];
        foreach ($this->data['organisationMemberships'] as $data) {
            $member = new CharacterOrganisation;
            $member->character_id = $this->model->id;
            $member->organisation_id = ImportIdMapper::get('organisations', $data['organisation_id']);
            $member->role = $data['role'] ?? null;
            $member->is_private = $data['is_private'] ?? false;
            $member->pin_id = $data['pin_id'] ?? null;
            $member->status_id = $data['status_id'] ?? null;
            if (! empty($data['parent_id']) && isset($parents[$data['parent_id']])) {
                $member->parent_id = $parents[$data['parent_id']];
            }
            $member->save();

            $parents[$data['id']] = $member->id;
        }

        return $this;
    }

    protected function characterLocations(): self
    {
        // Support old format
        if (! empty($this->data['location_id'])) {
            $locationID = ImportIdMapper::get('locations', $this->data['location_id']);
            if (! empty($locationID)) {
                $this->entity->locations()->attach($locationID);
            }
        }

        if (! Arr::has($this->data, 'entity.entityLocations')) {
            return $this;
        }
        // New 3.8 format
        foreach ($this->data['entity']['entityLocations'] as $location) {
            if (empty($location['location_id'])) {
                continue;
            }
            $locationID = ImportIdMapper::get('locations', $location['location_id']);
            if (empty($locationID)) {
                continue;
            }
            $this->entity->locations()->attach($locationID);
        }

        return $this;
    }
}

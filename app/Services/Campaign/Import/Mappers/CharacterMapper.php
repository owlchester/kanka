<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\ImportIdMapper;
use App\Models\Character;
use App\Models\CharacterOrganisation;
use App\Models\CharacterTrait;

class CharacterMapper extends MiscMFapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'created_at', 'location_id', 'updated_at', 'race_id', 'family_id'];

    protected string $className = Character::class;

    protected string $mappingName = 'characters';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('character_id');
    }

    public function second(): void
    {
        // @phpstan-ignore-next-line
        $this
            ->loadModel()
            ->foreign('locations', 'location_id')
            ->pivot('characterFamilies', 'families', 'family_id')
            ->pivot('characterRaces', 'races', 'race_id')
            ->saveModel()
            ->traits()
            ->memberships()
            ->entitySecond();
    }

    protected function traits(): self
    {
        if (empty($this->data['characterTraits'])) {
            return $this;
        }
        foreach ($this->data['characterTraits'] as $data) {
            $trait = new CharacterTrait;
            $trait->character_id = $this->model->id;
            $trait->name = $data['name'];
            $trait->entry = $data['entry'];
            $trait->is_private = $data['is_private'];
            $trait->section_id = $data['section_id'];
            $trait->default_order = $data['default_order'];
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
            $member->role = $data['role'];
            $member->is_private = $data['is_private'];
            $member->pin_id = $data['pin_id'];
            $member->status_id = $data['status_id'];
            if (! empty($data['parent_id']) && isset($parents[$data['parent_id']])) {
                $member->parent_id = $parents[$data['parent_id']];
            }
            $member->save();

            $parents[$data['id']] = $member->id;
        }

        return $this;
    }
}

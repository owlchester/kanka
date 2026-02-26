<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\ImportIdMapper;
use App\Models\Quest;
use App\Models\QuestElement;

class QuestMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'quest_id', 'created_at', 'updated_at', 'location_id', 'instigator_id'];

    protected string $className = Quest::class;

    protected string $mappingName = 'quests';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('quest_id');
    }

    public function second(): void
    {
        // @phpstan-ignore-next-line
        $this->loadModel()
            ->foreign('locations', 'location_id')
            ->foreign('entities', 'instigator_id')
            ->saveModel()
            ->elements()
            ->entitySecond();
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $quests = Quest::whereIn('id', $children)->get();
            /** @var Quest $model */
            foreach ($quests as $model) {
                $model->quest_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }

    protected function elements(): self
    {
        $fields = [
            'role', 'description', 'visibility_id', 'colour', 'name',
        ];
        foreach ($this->data['elements'] as $data) {
            $el = new QuestElement;
            $el->quest_id = $this->model->id;
            if (! empty($data['entity_id'])) {
                if (! ImportIdMapper::hasEntity($data['entity_id'])) {
                    continue;
                }
                $el->entity_id = ImportIdMapper::getEntity($data['entity_id']);
            }
            foreach ($fields as $field) {
                if (! array_key_exists($field, $data)) {
                    continue;
                }
                $el->$field = $data[$field];
            }
            $el->description = $this->mentions($el->description);
            $el->save();
            ImportIdMapper::putQuestElement($data['id'], $el->id);
        }

        return $this;
    }
}

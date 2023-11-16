<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\ImportIdMapper;
use App\Models\QuestElement;
use App\Models\Tag;
use App\Models\Quest;
use App\Traits\CampaignAware;

class QuestMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'quest_id', 'created_at', 'updated_at'];

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
        $this->loadModel()
            ->foreign('locations', 'location_id')
            ->saveModel()
            ->elements()
            ->entitySecond()
        ;
    }

    public function prepare(): self
    {
        $this->campaign->quests()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $quests = Quest::whereIn('id', $children)->get();
            /** @var Quest $quest */
            foreach ($quests as $quest) {
                $quest->setParentId($this->mapping[$parent]);
                $quest->save();
            }
        }

        return $this;
    }

    protected function elements(): self
    {
        $fields = [
            'role', 'description', 'visibility_id', 'colour', 'name'
        ];
        foreach ($this->data['elements'] as $data) {
            $el = new QuestElement();
            $el->quest_id = $this->model->id;
            if (!empty($data['entity_id'])) {
                if (!ImportIdMapper::hasEntity($data['entity_id'])) {
                    continue;
                }
                $el->entity_id = ImportIdMapper::getEntity($data['entity_id']);
            }
            foreach ($fields as $field) {
                $el->$field = $data[$field];
            }
            $el->description = $this->mentions($el->description);
            $el->save();
        }
        return $this;
    }
}

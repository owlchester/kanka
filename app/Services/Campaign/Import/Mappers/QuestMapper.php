<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Tag;
use App\Models\Quest;
use App\Traits\CampaignAware;

class QuestMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'quest_id', 'created_at', 'updated_at'];

    public function first(): void
    {
        $this
            ->prepareModel(Quest::class)
            ->trackMappings('quests', 'quest_id');
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
}

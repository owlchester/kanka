<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Tag;
use App\Traits\CampaignAware;

class TagMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'tag_id', 'created_at', 'updated_at'];

    public function first(): void
    {
        $this
            ->prepareModel(Tag::class)
            ->trackMappings('tags', 'tag_id');
    }

    public function prepare(): self
    {
        $this->campaign->tags()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $tags = Tag::whereIn('id', $children)->get();
            /** @var Tag $tag */
            foreach ($tags as $tag) {
                $tag->setParentId($this->mapping[$parent]);
                $tag->save();
            }
        }

        return $this;
    }
}

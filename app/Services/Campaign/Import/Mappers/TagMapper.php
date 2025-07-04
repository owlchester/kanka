<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Tag;

class TagMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'tag_id', 'created_at', 'updated_at'];

    protected string $className = Tag::class;

    protected string $mappingName = 'tags';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('tag_id');
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $tags = Tag::whereIn('id', $children)->get();
            /** @var Tag $model */
            foreach ($tags as $model) {
                $model->tag_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }
}

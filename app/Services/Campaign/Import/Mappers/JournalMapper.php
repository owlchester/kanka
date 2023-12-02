<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Journal;

class JournalMapper extends MiscMapper
{
    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'journal_id', 'created_at', 'updated_at'];

    protected string $className = Journal::class;
    protected string $mappingName = 'journals';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('journal_id');
    }

    public function second(): void
    {
        $this
            ->loadModel()
            ->foreign('locations', 'location_id')
            ->foreign('entities', 'author_id')
            ->saveModel()
            ->entitySecond();
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this, so it's going to be inefficient
            $models = Journal::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->setParentId($this->mapping[$parent]);
                $model->save();
            }
        }

        return $this;
    }
}

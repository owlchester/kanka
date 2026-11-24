<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Journal;

class JournalMapper extends StandardTreeMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'journal_id', 'location_id', 'author_id', 'created_at', 'updated_at'];

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
            ->entityLocations()
            ->foreign('entities', 'author_id')
            ->saveModel()
            ->entitySecond();
    }
}

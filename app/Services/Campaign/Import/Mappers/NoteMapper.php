<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Note;

class NoteMapper extends StandardTreeMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'note_id', 'created_at', 'updated_at'];

    protected string $className = Note::class;

    protected string $mappingName = 'notes';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('note_id');
    }
}

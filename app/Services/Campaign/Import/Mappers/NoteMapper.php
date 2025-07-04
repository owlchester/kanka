<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Note;

class NoteMapper extends MiscMapper
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

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Note::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->note_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }
}

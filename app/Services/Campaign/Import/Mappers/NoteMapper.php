<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Note;
use App\Services\Campaign\Import\GalleryAware;
use App\Traits\CampaignAware;

class NoteMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'note_id', 'created_at', 'updated_at'];

    public function first(): void
    {
        $this
            ->prepareModel(Note::class)
            ->trackMappings('notes', 'note_id');
    }

    public function prepare(): self
    {
        $this->campaign->notes()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Note::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->setParentId($this->mapping[$parent]);
                $model->save();
            }
        }

        return $this;
    }
}

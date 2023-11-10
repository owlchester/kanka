<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Entity;
use App\Models\Tag;
use App\Services\Campaign\Import\GalleryAware;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TagMapper
{
    use CampaignAware;
    use ImportMapper;
    use GalleryAware;
    use EntityMapper;

    protected array $mapping = [];
    protected Tag $model;
    protected array $parents = [];
    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'tag_id', 'created_at', 'updated_at'];

    public function import(): void
    {
        $this->model = new Tag();
        $this->model->campaign_id = $this->campaign->id;
        foreach ($this->data as $field => $value) {
            if (is_array($value) || in_array($field, $this->ignore)) {
                continue;
            }
            $this->model->$field = $value;
        }


        $this->model->save();
        $this->entity();


        dump('saving tag #' . $this->model->id);

        $this->mapping[$this->data['id']] = $this->model->id;
        if (!empty($this->data['tag_id'])) {
            $this->parents[$this->data['tag_id']][] = $this->model->id;
        }

    }

    public function prepare(): self
    {
        $this->campaign->tags()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mappings[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $tags = Tag::whereIn('id', $children)->get();
            /** @var Tag $tag */
            foreach ($tags as $tag) {
                $tag->setParentId($this->mappings[$parent]);
                $tag->save();
            }
        }

        return $this;
    }
}

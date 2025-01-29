<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Entity;
use App\Services\Campaign\Import\ImportMentions;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class CustomMapper
{
    use CampaignAware;
    use CustomEntityMapper;
    use ImportMapper;
    use ImportMentions;
    use UserAware;

    protected array $mapping = [];
    protected array $parents = [];
    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'parent_id', 'created_at', 'updated_at'];
    protected string $mappingName;
    
    public function prepare(): self
    {
        //$this->campaign->{$this->mappingName}()->forceDelete();
        return $this;
    }



    public function first(): void
    {
        $this
            ->prepareEntity()
            ->trackMappings('parent_id');
    }

    public function second(): void
    {
        $this
            ->loadEntity()
            ->saveEntity()
            ->entitySecond()
        ;    
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Entity::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->parent_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }

    public function third(): self
    {
        $this
            ->loadEntity()
            ->entityThird()
        ;
        return $this;
    }

}

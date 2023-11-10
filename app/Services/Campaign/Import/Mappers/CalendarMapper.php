<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Calendar;
use App\Services\Campaign\Import\GalleryAware;
use App\Traits\CampaignAware;

class CalendarMapper
{
    use CampaignAware;
    use ImportMapper;
    use GalleryAware;
    use EntityMapper;

    protected array $mapping = [];
    protected Calendar $model;
    protected array $parents = [];
    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'calendar_id', 'created_at', 'updated_at'];

    public function import(): void
    {
        $this->model = new Calendar();
        $this->model->campaign_id = $this->campaign->id;
        foreach ($this->data as $field => $value) {
            if (is_array($value) || in_array($field, $this->ignore)) {
                continue;
            }
            $this->model->$field = $value;
        }


        $this->model->save();
        $this->entity();

        dump('saving calendar #' . $this->model->id);

        $this->mapping[$this->data['id']] = $this->model->id;
        if (!empty($this->data['calendar_id'])) {
            $this->parents[$this->data['calendar_id']][] = $this->model->id;
        }
    }

    public function prepare(): self
    {
        $this->campaign->calendars()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mappings[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Calendar::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->setParentId($this->mappings[$parent]);
                $model->save();
            }
        }

        return $this;
    }
}

<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Calendar;
use App\Traits\CampaignAware;

class CalendarMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'calendar_id', 'created_at', 'updated_at'];

    protected string $className = Calendar::class;
    protected string $mappingName = 'calendars';
    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('calendar_id');
    }

    public function prepare(): self
    {
        $this->campaign->calendars()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Calendar::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->setParentId($this->mapping[$parent]);
                $model->save();
            }
        }

        return $this;
    }
}

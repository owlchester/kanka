<?php

namespace App\Models\Concerns;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int|bool $is_template
 *
 * @method static self|Builder template(Campaign $campaign, int $template, bool $template)
 * @method static self|Builder postTemplates(Campaign $campaign, bool $template = true)
 */
trait Templatable
{
    public function isTemplate(): bool
    {
        return (bool) $this->is_template;
    }

    public function scopeTemplate(Builder $query, bool $template = true): Builder
    {
        return $query->select($this->getTable() . '.*')
            ->where($this->getTable() . '.is_template', $template);
    }

    public function scopePostTemplates(Builder $query, Campaign $campaign, bool $template = true): Builder
    {
        return $query->select($this->getTable() . '.*')
            ->leftJoin('entities as e', 'e.id', $this->getTable() . '.entity_id')
            ->where('e.campaign_id', $campaign->id)
            ->where($this->getTable() . '.is_template', $template);
    }
}

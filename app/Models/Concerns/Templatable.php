<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property int|bool $is_template
 *
 * @method static self|Builder template(bool $template)
 */
trait Templatable
{
    public function isTemplate(): bool
    {
        return (bool) $this->is_template;
    }

    /**
     */
    public function scopeTemplate(Builder $query, bool $template = true): Builder
    {
        return $query->where('is_template', $template);
    }
}

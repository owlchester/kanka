<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\Filterable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $section
 * @property int $created_by
 * @property bool $is_active
 * @property string $customer
 * @property string $html
 */
class Ad extends Model
{
    const SECTION_SIDEBAR = 1;
    const SECTION_BANNER = 2;
    const SECTION_FOOTER = 3;

    public function scopeSection(Builder $query, int $section)
    {
        return $query->where('section', $section);
    }
}

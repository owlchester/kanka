<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $section
 * @property int $created_by
 * @property bool|int $is_active
 * @property string $customer
 * @property string $html
 */
class Ad extends Model
{
    public const int SECTION_SIDEBAR = 1;

    public const int SECTION_BANNER = 2;

    public const int SECTION_FOOTER = 3;

    public function scopeSection(Builder $query, int $section)
    {
        return $query->where('section', $section);
    }

    public function isSidebar(): bool
    {
        return $this->section == self::SECTION_SIDEBAR;
    }
}

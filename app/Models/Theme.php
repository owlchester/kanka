<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Theme
 * @package App\Models
 *
 * @property string $name
 */
class Theme extends Model
{
    use SoftDeletes;

    public function campaigns(): HasMany
    {
        return $this->hasMany('App\Models\Campaign', 'theme_id');
    }

    /**
     */
    public function __toString(): string
    {
        return __('profiles.theme.themes.' . $this->name);
    }
}

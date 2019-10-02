<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaigns()
    {
        return $this->hasMany('App\Models\Campaign', 'theme_id');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return __('profiles.theme.themes.' . $this->name);
    }
}

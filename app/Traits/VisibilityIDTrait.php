<?php

namespace App\Traits;

use App\Models\Scopes\VisibilityIDScope;
use App\Models\Visibility;

/**
 * Trait VisibilityTrait
 *
 * Prioritize using this package where the visibility is an id, rather than the
 * old one with a string.
 *
 * @package App\Traits
 *
 * @property string|int|null $visibility_id
 */
trait VisibilityIDTrait
{
    protected bool $skipAllIcon = false;
    /**
     * Add the Visible scope as a default scope to this model
     */
    public static function bootVisibilityIDTrait()
    {
        static::addGlobalScope(new VisibilityIDScope());
    }

    public function skipAllIcon(): self
    {
        $this->skipAllIcon = true;
        return $this;
    }

    /**
     * Generate the html icon for visibility
     * @param string|null $extra
     * @return string
     */
    public function visibilityIcon(string $extra = null): string
    {
        $class = $title = '';
        if ($this->visibility_id == Visibility::VISIBILITY_ALL) {
            if ($this->skipAllIcon) {
                return '';
            }
            $class = 'fa-solid fa-eye';
            $title = __('crud.visibilities.all');
        } elseif ($this->visibility_id == Visibility::VISIBILITY_ADMIN) {
            $class = 'fa-solid fa-lock';
            $title = __('crud.visibilities.admin');
        } elseif ($this->visibility_id == Visibility::VISIBILITY_SELF) {
            $class = 'fa-solid fa-user-secret';
            $title = __('crud.visibilities.self');
        } elseif ($this->visibility_id == Visibility::VISIBILITY_ADMIN_SELF) {
            $class = 'fa-solid fa-user-lock';
            $title = __('crud.visibilities.admin-self');
        } elseif ($this->visibility_id == Visibility::VISIBILITY_MEMBERS) {
            $class = 'fa-solid fa-users';
            $title = __('crud.visibilities.members');
        }

        return '<i class="' . rtrim($class . ' ' . $extra) . '" title="' . $title . '" data-toggle="tooltip" aria-hiden="true"></i>';
    }
}

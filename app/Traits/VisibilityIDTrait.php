<?php

namespace App\Traits;

use App\Models\Scopes\VisibilityIDScope;
use App\Models\Visibility;

/**
 * Trait VisibilityTrait
 * @package App\Traits
 *
 * @property string $visibility_id
 * @property int $created_by
 */
trait VisibilityIDTrait
{
    /**
     * Add the Visible scope as a default scope to this model
     */
    public static function bootVisibilityIDTrait()
    {
        static::addGlobalScope(new VisibilityIDScope());
    }

    /**
     * @return string
     */
    public function visibilityIcon(string $extra = ''): string
    {
        if ($this->visibility_id == Visibility::VISIBILITY_ALL) {
            return '';
        }

        $class = $title = '';
        if ($this->visibility_id == Visibility::VISIBILITY_ADMIN) {
            $class = 'fas fa-lock';
            $title = __('crud.visibilities.admin');
        } elseif ($this->visibility_id == Visibility::VISIBILITY_SELF) {
            $class = 'fas fa-user-secret';
            $title = __('crud.visibilities.self');
        } elseif ($this->visibility_id == Visibility::VISIBILITY_ADMIN_SELF) {
            $class = 'fas fa-user-lock';
            $title = __('crud.visibilities.admin-self');
        } elseif ($this->visibility_id == Visibility::VISIBILITY_MEMBERS) {
            $class = 'fas fa-users';
            $title = __('crud.visibilities.members');
        }

        return '<i class="' . rtrim($class . ' ' . $extra) . '" title="' . $title . '"></i>';
    }
}

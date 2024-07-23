<?php

namespace App\Traits;

use App\Enums\Visibility;
use App\Models\Scopes\VisibilityIDScope;

/**
 * Trait VisibilityTrait
 *
 * Prioritize using this package where the visibility is an id, rather than the
 * old one with a string.
 *
 * @package App\Traits
 *
 * @property string|int|Visibility|null $visibility_id
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
     */
    public function visibilityIcon(?string $extra = null)
    {
        $class = $title = '';
        if ($this->visibility_id === Visibility::All) {
            if ($this->skipAllIcon) {
                return '';
            }
            $class = 'eye';
            $title = __('crud.visibilities.all');
        } elseif ($this->visibility_id === Visibility::Admin) {
            $class = 'lock';
            $title = __('crud.visibilities.admin');
        } elseif ($this->visibility_id === Visibility::Self) {
            $class = 'user-secret';
            $title = __('crud.visibilities.self');
        } elseif ($this->visibility_id === Visibility::AdminSelf) {
            $class = 'user-lock';
            $title = __('crud.visibilities.admin-self');
        } elseif ($this->visibility_id === Visibility::Member) {
            $class = 'users';
            $title = __('crud.visibilities.members');
        }

        return view('icons.visibility', ['class' => $class, 'extra' => $extra, 'title' => $title]);

        return '<i class="' . rtrim($class . ' ' . $extra) . '" data-title="' . $title . '" data-toggle="tooltip" aria-hidden="true"></i>';
    }

    public function visibilityName(): string
    {
        if ($this->visibility_id === Visibility::All->value) {
            if ($this->skipAllIcon) {
                return '';
            }
            return __('crud.visibilities.all');
        } elseif ($this->visibility_id === Visibility::Admin->value) {
            return __('crud.visibilities.admin');
        } elseif ($this->visibility_id === Visibility::Self->value) {
            return __('crud.visibilities.self');
        } elseif ($this->visibility_id === Visibility::AdminSelf->value) {
            return __('crud.visibilities.admin-self');
        } elseif ($this->visibility_id === Visibility::Member->value) {
            return __('crud.visibilities.members');
        }

        return 'Unknown';
    }

    /**
     * Get a list of visibility options when editing an element
     */
    public function visibilityOptions(): array
    {
        $options = [];
        $options[Visibility::All->value] = __('crud.visibilities.all');

        if (auth()->user()->isAdmin()) {
            $options[Visibility::Admin->value] = __('crud.visibilities.admin');
            $options[Visibility::Member->value] = __('crud.visibilities.members');
        }
        if ($this->isCreator()) {
            $options[Visibility::Self->value] = __('crud.visibilities.self');
            $options[Visibility::AdminSelf->value] = __('crud.visibilities.admin-self');
        }

        // If it's a visibility self & admin, and we're not the creator, we can't change this
        if ($this->visibility_id === Visibility::AdminSelf->value && !$this->isCreator()) {
            $options = [Visibility::AdminSelf->value => __('crud.visibilities.admin-self')];
        } elseif ($this->visibility_id === Visibility::Self->value && !$this->isCreator()) {
            $options = [Visibility::Self->value => __('crud.visibilities.self')];
        }

        return $options;
    }

    /**
     * Determine if the current user is the creator
     */
    protected function isCreator(): bool
    {
        return $this->created_by == auth()->user()->id;
    }
}

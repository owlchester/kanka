<?php

namespace App\Models\Concerns;

use App\Enums\Visibility;
use App\Models\Scopes\VisibilityIDScope;
use App\Observers\VisibilityObserver;

/**
 * Trait VisibilityTrait
 *
 * Add a visibility permission to subelements, using the Visibility enum
 *
 * @package App\Traits
 *
 * @property ?Visibility $visibility_id
 */
trait HasVisibility
{
    protected bool $skipAllIcon = false;

    /**
     * Add the Visible scope as a default scope to this model
     */
    public static function bootHasVisibility()
    {
        static::addGlobalScope(new VisibilityIDScope());
        static::observe(app(VisibilityObserver::class));
    }

    public function skipAllIcon(): self
    {
        $this->skipAllIcon = true;
        return $this;
    }

    /**
     * Generate the data for the visibility icon
     */
    public function visibilityIcon(?string $extra = null): array
    {
        $icon = [];

        if ($this->visibility_id === Visibility::All) {
            if ($this->skipAllIcon) {
                $icon['skip'] = true;
                return $icon;
            }
            $icon['class'] = 'fa-solid fa-eye';
            $icon['key'] = __('visibilities.helpers.all');
        } elseif ($this->visibility_id === Visibility::Admin) {
            $icon['class'] = 'fa-solid fa-lock';
            $icon['key'] = __('visibilities.helpers.admin');
        } elseif ($this->visibility_id === Visibility::Self) {
            $icon['class'] = 'fa-solid fa-user-secret';
            $icon['key'] = __('visibilities.helpers.self');
        } elseif ($this->visibility_id === Visibility::AdminSelf) {
            $icon['class'] = 'fa-solid fa-user-lock';
            $icon['key'] = __('visibilities.helpers.admin-self');
        } elseif ($this->visibility_id === Visibility::Member) {
            $icon['class'] = 'fa-solid fa-users';
            $icon['key'] = __('visibilities.helpers.members');
        }

        $icon['class'] = mb_rtrim($icon['class'] . ' ' . $extra);

        return $icon;
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

        return __('crud.visibilities.all');
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

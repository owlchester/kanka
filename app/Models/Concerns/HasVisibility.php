<?php

namespace App\Models\Concerns;

use App\Enums\Visibility;
use App\Models\Scopes\VisibilityIDScope;
use App\Observers\VisibilityObserver;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait VisibilityTrait
 *
 * Add a visibility permission to subelements, using the Visibility enum
 *
 *
 * @property ?Visibility $visibility_id
 *
 * @method static self|Builder withPrivate()
 */
trait HasVisibility
{
    protected bool $skipAllIcon = false;

    /**
     * Add the Visible scope as a default scope to this model
     */
    public static function bootHasVisibility()
    {
        static::addGlobalScope(new VisibilityIDScope);
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

        if ($this->isVisibleAll()) {
            if ($this->skipAllIcon) {
                $icon['skip'] = true;

                return $icon;
            }
            $icon['class'] = 'fa-regular fa-eye';
            $icon['key'] = __('visibilities.helpers.all');
        } elseif ($this->isVisibleAdmin()) {
            $icon['class'] = 'fa-regular fa-lock';
            $icon['key'] = __('visibilities.helpers.admin');
        } elseif ($this->visibility_id === Visibility::Self) {
            $icon['class'] = 'fa-regular fa-user-secret';
            $icon['key'] = __('visibilities.helpers.self');
        } elseif ($this->visibility_id === Visibility::AdminSelf) {
            $icon['class'] = 'fa-regular fa-user-lock';
            $icon['key'] = __('visibilities.helpers.admin-self');
        } elseif ($this->visibility_id === Visibility::Member) {
            $icon['class'] = 'fa-regular fa-users';
            $icon['key'] = __('visibilities.helpers.members');
        }

        $icon['class'] = mb_rtrim($icon['class'] . ' ' . $extra);

        return $icon;
    }

    public function visibilityName(): string
    {
        if ($this->isVisibleAll()) {
            if ($this->skipAllIcon) {
                return '';
            }

            return __('crud.visibilities.all');
        } elseif ($this->isVisibleAdmin()) {
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
        if ($this->visibility_id === Visibility::AdminSelf->value && ! $this->isCreator()) {
            $options = [Visibility::AdminSelf->value => __('crud.visibilities.admin-self')];
        } elseif ($this->visibility_id === Visibility::Self->value && ! $this->isCreator()) {
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

    public function isVisibleAll(): bool
    {
        return $this->visibility_id === Visibility::All;
    }

    public function isVisibleAdmin(): bool
    {
        return $this->visibility_id === Visibility::Admin;
    }
}

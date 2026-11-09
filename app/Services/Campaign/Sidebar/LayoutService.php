<?php

namespace App\Services\Campaign\Sidebar;

use App\Enums\Permission;
use App\Events\Campaigns\Sidebar\SidebarSaved;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\CampaignRoleUser;
use App\Models\EntityType;
use App\Models\Scopes\PrivateScope;
use App\Models\User;
use App\Services\Permissions\EntityPermission;
use App\Traits\CampaignAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class LayoutService
{
    use CampaignAware;

    protected array $catalog;

    protected array $types;

    protected array $bookmarks;

    public function enabled(): bool
    {
        return (bool) Arr::get($this->campaign->ui_settings, 'sidebar_v2.enabled', false);
    }

    public function usesV2(): bool
    {
        return ! $this->campaign->boosted() || $this->enabled();
    }

    public function revision(): string
    {
        return hash('sha256', json_encode([
            $this->campaign->ui_settings['sidebar_v2'] ?? [],
            array_keys($this->catalog()),
        ]));
    }

    public function catalog(): array
    {
        if (isset($this->catalog)) {
            return $this->catalog;
        }

        $this->catalog = [];
        $this->types = [];
        foreach (EntityType::inCampaign($this->campaign)->orderBy('position')->orderBy('id')->get() as $type) {
            if ($type->isBookmark()) {
                continue;
            }
            $id = 'category:' . $type->id;
            $this->types[$id] = $type;
            $this->catalog[$id] = [
                'id' => $id,
                'kind' => 'category',
                'label' => $type->plural(),
                'icon' => $type->icon(),
                'url' => route('entities.index', [$this->campaign, $type->id]),
                'required' => false,
                'disabled' => ! $this->categoryEnabled($type),
            ];
        }

        $this->bookmarks = [];
        foreach ($this->campaign->bookmarks()->withoutGlobalScope(PrivateScope::class)->ordered()->with(['target.entityType', 'entityType', 'randomEntityType', 'dashboard'])->get() as $bookmark) {
            $bookmark->setRelation('campaign', $this->campaign);
            $id = 'bookmark:' . $bookmark->id;
            $this->bookmarks[$id] = $bookmark;
            $this->catalog[$id] = [
                'id' => $id,
                'kind' => 'bookmark',
                'label' => $bookmark->name,
                'icon' => $bookmark->iconClass(),
                'required' => false,
                'disabled' => ! $bookmark->is_active || ! $this->campaign->enabled('bookmarks'),
            ];
        }

        foreach ([
            'dashboard' => ['sidebar.dashboard', 'fa-duotone fa-house', 'dashboard', null],
            'gallery' => ['sidebar.gallery', 'fa-duotone fa-images', 'gallery', 'gallery'],
            'relations' => ['sidebar.relations', 'fa-duotone fa-circle-nodes', 'relations.index', 'relations'],
            'history' => ['sidebar.recent', 'fa-duotone fa-clock-rotate-left', 'history.index', 'recover'],
            'settings' => ['sidebar.settings', 'fa-duotone fa-cog', 'overview', null],
        ] as $key => [$label, $icon, $route, $permission]) {
            $id = 'system:' . $key;
            $this->catalog[$id] = compact('id', 'icon', 'permission') + [
                'kind' => 'system', 'label' => __($label),
                'url' => route($route, $this->campaign), 'required' => true,
            ];
        }

        return $this->catalog;
    }

    public function standard(): array
    {
        $catalog = $this->catalog();
        $groups = [
            'world' => ['character', 'location', 'map', 'organisation', 'family', 'creature', 'race'],
            'time' => ['calendar', 'timeline', 'event', 'journal'],
            'game' => ['quest', 'item', 'ability'],
            'other' => ['tag', 'conversation', 'dice_roll', 'attribute_template', 'whiteboard'],
        ];
        $items = [['id' => 'system:dashboard'], $this->bookmarkSection()];
        $placed = [];
        foreach ($groups as $group => $codes) {
            $children = [];
            foreach ($codes as $code) {
                foreach ($this->types as $id => $type) {
                    if ($type->isStandardCode($code)) {
                        $children[] = ['id' => $id];
                        $placed[] = $id;
                    }
                }
            }
            $items[] = ['id' => $group, 'label_key' => 'sidebar.' . $group, 'children' => $children];
        }
        foreach ($this->types as $id => $type) {
            if ($type->isCustom()) {
                $items[1]['children'][] = ['id' => $id];
            } elseif (! in_array($id, $placed, true)) {
                $items[] = ['id' => $id];
            }
        }
        foreach (array_keys($this->bookmarks) as $id) {
            $items[1]['children'][] = ['id' => $id];
        }
        foreach (['relations', 'gallery', 'history', 'settings'] as $key) {
            $items[] = ['id' => 'system:' . $key];
        }

        return ['items' => $items, 'known' => array_keys($catalog)];
    }

    public function layout(string $target = 'default'): array
    {
        $layout = Arr::get($this->campaign->ui_settings, 'sidebar_v2.layouts.' . $target);
        if (! is_array($layout)) {
            return $target === 'default' ? $this->standard() : $this->layout();
        }

        $new = array_diff(array_keys($this->catalog()), $layout['known']);
        foreach ($layout['items'] as &$item) {
            if ($item['id'] !== 'bookmarks' || ! isset($item['children'])) {
                continue;
            }
            foreach ($new as $id) {
                $item['children'][] = ['id' => $id];
            }
        }
        unset($item);
        $layout['known'] = array_keys($this->catalog());

        return $layout;
    }

    public function target(?User $user): string
    {
        $layouts = Arr::get($this->campaign->ui_settings, 'sidebar_v2.layouts', []);
        $roles = $user ? CampaignRoleUser::where('user_id', $user->id)
            ->whereHas('campaignRole', fn ($query) => $query->where('campaign_id', $this->campaign->id))
            ->orderBy('position')->orderBy('id')->pluck('campaign_role_id')->all() : [];

        if (empty($roles)) {
            $roles = $this->campaign->roles()->where('is_public', true)->pluck('id')->all();
        }
        foreach ($roles as $role) {
            if (isset($layouts[(string) $role])) {
                return (string) $role;
            }
        }

        return 'default';
    }

    public function render(?User $user): array
    {
        $catalog = $this->catalog();
        $layout = $this->campaign->boosted() ? $this->layout($this->target($user)) : $this->standard();
        $permissions = app(EntityPermission::class)->campaign($this->campaign);
        $user ? $permissions->user($user) : $permissions->userless();
        $visible = [];
        $admin = $user && $user->can('admin', $this->campaign);
        foreach ($catalog as $id => $entry) {
            if ($entry['kind'] === 'category') {
                $type = $this->types[$id];
                if (! $this->categoryEnabled($type) || ! $permissions->hasPermission($type->id, Permission::View->value)) {
                    continue;
                }
            } elseif ($entry['kind'] === 'bookmark') {
                $bookmark = $this->bookmarks[$id];
                if (! $this->bookmarkVisible($bookmark, $permissions, $admin)) {
                    continue;
                }
                $entry['bookmark'] = $bookmark;
            } elseif ($entry['permission'] && (! $user || ! $user->can($entry['permission'], $this->campaign))) {
                continue;
            }
            $visible[$id] = $entry;
        }

        $items = [];
        foreach ($layout['items'] as $node) {
            if (isset($node['children'])) {
                $children = [];
                foreach ($node['children'] as $child) {
                    if (isset($visible[$child['id']])) {
                        $children[] = $visible[$child['id']];
                    }
                }
                $url = $node['id'] === 'bookmarks' && $this->campaign->enabled('bookmarks') && $user?->can('create', [Bookmark::class, $this->campaign])
                    ? route('bookmarks.index', $this->campaign) : null;
                if ($children || $url) {
                    $items[] = [
                        'id' => $node['id'],
                        'label' => $node['label'] ?? __($node['label_key']),
                        'children' => $children,
                        'url' => $url,
                    ];
                }
            } elseif (isset($visible[$node['id']])) {
                $items[] = $visible[$node['id']];
            }
        }

        return $items;
    }

    public function validateItems(array $items): void
    {
        $catalog = $this->catalog();
        $seen = [];
        $sections = [];
        foreach ($items as $node) {
            if (isset($node['children'])) {
                if ((empty(trim($node['label'] ?? '')) && empty($node['label_key'])) || isset($catalog[$node['id']]) || in_array($node['id'], $sections, true)) {
                    throw ValidationException::withMessages(['items' => __('campaigns/sidebar-v2.errors.structure')]);
                }
                $sections[] = $node['id'];
                foreach ($node['children'] as $child) {
                    $seen[] = $child['id'];
                }
            } else {
                $seen[] = $node['id'];
            }
        }
        $required = array_keys(array_filter($catalog, fn ($entry) => $entry['required']));
        if (count($seen) !== count(array_unique($seen)) || array_diff($seen, array_keys($catalog)) || array_diff($required, $seen) || ! in_array('bookmarks', $sections, true)) {
            throw ValidationException::withMessages(['items' => __('campaigns/sidebar-v2.errors.structure')]);
        }
    }

    public function save(array $data, User $user): void
    {
        DB::transaction(function () use ($data) {
            $campaign = Campaign::whereKey($this->campaign->id)->lockForUpdate()->firstOrFail();
            $this->campaign = $campaign;
            if (! hash_equals($this->revision(), $data['revision'])) {
                throw ValidationException::withMessages(['revision' => __('campaigns/sidebar-v2.errors.conflict')]);
            }
            $ui = $campaign->ui_settings ?? [];
            $settings = $ui['sidebar_v2'] ?? [];
            $target = $data['target'];
            if ($data['action'] === 'legacy') {
                $settings['enabled'] = false;
            } elseif ($data['action'] === 'start') {
                $settings = ['enabled' => true, 'layouts' => ['default' => $this->standard()]];
            } elseif ($data['action'] === 'resume') {
                $settings['enabled'] = true;
            } elseif ($data['action'] === 'reset') {
                unset($settings['layouts'][$target]);
            } else {
                abort_unless($this->enabled(), 409);
                $this->validateItems($data['items']);
                $settings['layouts'][$target] = ['items' => $data['items'], 'known' => array_keys($this->catalog())];
            }
            $ui['sidebar_v2'] = $settings;
            $campaign->ui_settings = $ui;
            $campaign->save();
        });
        SidebarSaved::dispatch($this->campaign, $user);
    }

    protected function bookmarkSection(): array
    {
        return ['id' => 'bookmarks', 'label_key' => 'entities.bookmarks', 'children' => []];
    }

    protected function categoryEnabled(EntityType $type): bool
    {
        return $type->isEnabled() && ($type->isCustom() ? $this->campaign->boosted() : $this->campaign->enabled($type));
    }

    protected function bookmarkVisible(Bookmark $bookmark, EntityPermission $permissions, bool $admin): bool
    {
        if (! $this->campaign->enabled('bookmarks') || ! $bookmark->is_active || ($bookmark->is_private && ! $admin)) {
            return false;
        }
        if ($bookmark->dashboard_id) {
            return $bookmark->dashboard && $this->campaign->boosted() && $bookmark->isValidDashboard();
        }
        if ($bookmark->isRandom() && $bookmark->random_entity_type === 'any') {
            return true;
        }
        if ($bookmark->entity_id && ! $bookmark->isRandom()) {
            return $bookmark->target && $bookmark->target->campaign_id === $this->campaign->id
                && $this->categoryEnabled($bookmark->target->entityType) && Gate::allows('view', $bookmark->target);
        }
        $type = $bookmark->isRandom() ? $bookmark->randomEntityType : $bookmark->entityType;

        return $type && (! $type->campaign_id || $type->campaign_id === $this->campaign->id)
            && $this->categoryEnabled($type) && $permissions->hasPermission($type->id, Permission::View->value);
    }
}

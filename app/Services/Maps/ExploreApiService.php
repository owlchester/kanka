<?php

namespace App\Services\Maps;

use App\Enums\Visibility;
use App\Facades\CampaignCache;
use App\Facades\EntityPermission;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Http\Resources\Maps\Explore\MapResource;
use App\Http\Resources\Maps\Explore\PinResource;
use App\Http\Resources\Maps\Explore\PresetResource;
use App\Models\Entity;
use App\Models\Map;
use App\Models\Preset;
use App\Models\PresetType;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class ExploreApiService
{
    use CampaignAware;
    use UserAware;

    protected Map $map;

    public function map(Map $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function load(): array
    {
        $mapEntity = $this->map->entity;

        return [
            'map' => new MapResource($this->map)->campaign($this->campaign),
            'layers' => LayerResource::collection(
                $this->map->layers
                    ->filter(fn ($layer) => $layer->isExplorable())
                    ->values()
            ),
            'groups' => GroupResource::collection($this->map->groups),
            'pins' => $this->map->markers
                ->filter(fn ($marker) => $marker->visible())
                ->values()
                ->map(fn ($marker) => new PinResource($marker)->campaign($this->campaign)->mapEntity($mapEntity))
                ->all(),
            'visibilities' => $this->visibilityOptions(),
            'default_visibility_id' => $this->campaign->defaultVisibility()->value,
            'presets' => $this->presets($mapEntity),
            'can_manage_presets' => $this->canManagePresets(),
            'i18n' => $this->translations(),
            'interactive' => $this->interactive(),
        ];
    }

    /**
     * Marker presets, only exposed to users who can edit this map — the Vue explorer only
     * offers them from the marker create panel, which itself is edit-gated. Applying an
     * existing preset only requires edit access; creating/managing one requires admin
     * (see canManagePresets()).
     */
    protected function presets(Entity $mapEntity): array
    {
        if (! $this->hasUser()) {
            return [];
        }

        // Explicitly scope EntityPermission to this campaign first (mirroring
        // Entity/Maps/MarkerController's store/update/destroy) so `can('update', ...)` checks
        // the user's actual role instead of falling back to EntityPermission::loadAllPermissions()'s
        // "no campaign set" admin bypass.
        EntityPermission::campaign($this->campaign);

        if (! $this->user->can('update', $this->map->entity)) {
            return [];
        }

        return Preset::inType(PresetType::MARKER)->orderBy('name')->get()
            ->map(fn ($preset) => new PresetResource($preset)->campaign($this->campaign)->mapEntity($mapEntity))
            ->all();
    }

    /**
     * Whether the current user can create/edit/delete marker presets (campaign admins only),
     * mirroring the legacy CampaignPolicy::mapPresets gate.
     */
    protected function canManagePresets(): bool
    {
        return $this->hasUser() && $this->user->can('mapPresets', $this->campaign);
    }

    /**
     * Visibility options available when creating a brand new marker. Mirrors the "new record"
     * branch of resources/views/entities/pages/posts/forms/_visibility.blade.php: Self/AdminSelf
     * are always offered (the current user will become the creator), Admin/Member only for admins.
     */
    protected function visibilityOptions(): array
    {
        $options = [
            ['id' => Visibility::All->value, 'name' => __('crud.visibilities.all')],
        ];

        if (auth()->user()->can('admin', $this->campaign)) {
            $options[] = ['id' => Visibility::Admin->value, 'name' => __('crud.visibilities.admin')];
            $options[] = ['id' => Visibility::Member->value, 'name' => __('crud.visibilities.members')];
        }

        $options[] = ['id' => Visibility::Self->value, 'name' => __('crud.visibilities.self')];
        $options[] = ['id' => Visibility::AdminSelf->value, 'name' => __('crud.visibilities.admin-self')];

        return $options;
    }

    protected function interactive(): ?array
    {
        $key = config('broadcasting.connections.reverb.key');
        if (empty($key) || ! $this->hasUser()) {
            return null;
        }

        if (! $this->user->can('view', $this->map->entity)) {
            return null;
        }

        return [
            'key' => $key,
            'host' => config('broadcasting.connections.reverb.options.host'),
            'port' => config('broadcasting.connections.reverb.options.port'),
            'scheme' => config('broadcasting.connections.reverb.options.scheme'),
            'channel' => 'map.' . $this->map->id,
            'show_presence' => CampaignCache::campaign($this->campaign)->members()->count() > 1,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
        ];
    }

    protected function translations(): array
    {
        $minInitial = Map::MIN_ZOOM;
        $maxInitial = Map::MAX_ZOOM_REAL;
        $defaultInitial = 0;

        if ($this->map->isTiled()) {
            $minInitial = Map::MIN_ZOOM_TILE;
            $maxInitial = Map::MAX_ZOOM_TILE;
            $defaultInitial = $minInitial;
        }

        return [
            'legend_title' => __('maps.panels.legend'),
            'legend_search' => __('maps/explorer.legend.search'),
            'legend_expand' => __('maps/explorer.legend.expand'),
            'legend_collapse' => __('maps/explorer.legend.collapse'),
            'ungrouped' => __('maps/explorer.ungrouped'),
            'loading' => __('maps/explorer.loading'),
            'error_load' => __('maps/explorer.errors.load'),
            'error_delete' => __('maps/explorer.errors.delete'),
            'error_save' => __('maps/explorer.errors.save'),
            'error_name_required' => __('maps/explorer.errors.name_required'),
            'tiling' => [
                'running' => __('maps/explorer.tiling.running'),
            ],
            'tiling_prompt' => [
                'message' => __('maps/explorer.tiling_prompt.message'),
                'migrate' => __('maps/explorer.tiling_prompt.migrate'),
                'dismiss' => __('maps/explorer.tiling_prompt.dismiss'),
            ],
            'from_entry' => __('maps/explorer.marker.from_entry'),
            'linked_entry' => __('maps/explorer.marker.linked_entry'),
            'description' => __('maps/explorer.marker.description'),
            'add_description' => __('maps/explorer.marker.add_description'),
            'edit_description' => __('maps/explorer.marker.edit_description'),
            'description_expand' => __('maps/explorer.marker.description_expand'),
            'cancel' => __('maps/explorer.marker.cancel'),
            'edit_marker' => __('maps/explorer.marker.edit_marker'),
            'center' => __('maps/explorer.marker.center'),
            'duplicate' => __('maps/explorer.marker.duplicate'),
            'delete_marker' => __('maps/explorer.marker.delete'),
            'delete_confirm' => __('maps/explorer.marker.delete_confirm'),
            'new_pin' => __('maps/explorer.marker.new_pin'),
            'name_placeholder' => __('maps/explorer.marker.name_placeholder'),
            'save' => __('maps/explorer.marker.save'),
            'save_changes' => __('maps/explorer.marker.save_changes'),
            'save_continue' => __('maps/explorer.marker.save_continue'),
            'rapid_active_hint' => __('maps/explorer.marker.rapid_active_hint'),
            'details' => __('maps/explorer.marker.details'),
            'less' => __('maps/explorer.marker.less'),
            'shape' => __('maps/explorer.marker.shape'),
            'templates' => __('maps/explorer.marker.templates'),
            'save_current' => __('maps/explorer.marker.save_current'),
            'new_template' => __('maps/explorer.marker.new_template'),
            'untitled_template' => __('maps/explorer.marker.untitled_template'),
            'name' => __('maps/explorer.marker.name'),
            'template_name_placeholder' => __('maps/explorer.marker.template_name_placeholder'),
            'create_template' => __('maps/explorer.marker.create_template'),
            'error_save_template' => __('maps/explorer.marker.error_save_template'),
            'error_template_name_required' => __('maps/explorer.marker.error_template_name_required'),
            'manage' => __('maps/explorer.marker.manage'),
            'done' => __('maps/explorer.marker.done'),
            'edit_template' => __('maps/explorer.marker.edit_template'),
            'delete_template' => __('maps/explorer.marker.delete_template'),
            'error_delete_template' => __('maps/explorer.marker.error_delete_template'),
            'group' => __('maps/explorer.marker.group'),
            'none' => __('maps/explorer.marker.none'),
            'visibility' => __('maps/explorer.marker.visibility'),
            'colour' => __('maps/explorer.marker.colour'),
            'border_colour' => __('maps/explorer.marker.border_colour'),
            'stroke_width' => __('maps/explorer.marker.stroke_width'),
            'stroke_thin' => __('maps/explorer.marker.stroke_thin'),
            'stroke_normal' => __('maps/explorer.marker.stroke_normal'),
            'stroke_bold' => __('maps/explorer.marker.stroke_bold'),
            'opacity' => __('maps/explorer.marker.opacity'),
            'custom' => __('maps/explorer.marker.custom'),
            'premium_custom_icon' => __('maps/explorer.marker.premium_custom_icon'),
            'markers_count_one' => __('maps/explorer.markers_count.one'),
            'markers_count_other' => __('maps/explorer.markers_count.other'),
            'peek_map' => __('maps/explorer.marker.peek_map'),
            'peek_panel' => __('maps/explorer.marker.peek_panel'),
            'advanced' => __('maps/explorer.marker.advanced'),
            'is_draggable' => __('maps/explorer.marker.is_draggable'),
            'is_draggable_help' => __('maps/explorer.marker.is_draggable_help'),
            'css_class' => __('maps/explorer.marker.css_class'),
            'css_class_help' => __('maps/explorer.marker.css_class_help'),
            'toolbar' => [
                'rapid' => __('maps/explorer.toolbar.rapid'),
                'rapid_hint' => __('maps/explorer.toolbar.rapid_hint'),
                'pin' => __('maps/explorer.toolbar.pin'),
                'text' => __('maps/explorer.toolbar.text'),
                'area' => __('maps/explorer.toolbar.area'),
                'circle' => __('maps/explorer.toolbar.circle'),
                'path' => __('maps/explorer.toolbar.path'),
                'helper' => [
                    'pin' => __('maps/explorer.toolbar.helper.pin'),
                    'text' => __('maps/explorer.toolbar.helper.text'),
                    'area' => __('maps/explorer.toolbar.helper.area'),
                    'circle' => __('maps/explorer.toolbar.helper.circle'),
                    'path' => __('maps/explorer.toolbar.helper.path'),
                ],
            ],
            'header' => [
                'overview' => __('maps/explorer.header.overview'),
                'settings' => __('maps/explorer.header.settings'),
                'edit' => __('maps/explorer.header.edit'),
            ],
            'settings' => [
                'title' => __('maps/explorer.settings.title'),
                'grid' => __('maps/explorer.settings.grid'),
                'grid_help' => __('maps/explorer.settings.grid_help'),
                'zoom_min' => __('maps/explorer.settings.zoom_min'),
                'zoom_min_help' => __('maps/explorer.settings.zoom_min_help', ['min' => Map::MIN_ZOOM, 'default' => -2]),
                'zoom_max' => __('maps/explorer.settings.zoom_max'),
                'zoom_max_help' => __('maps/explorer.settings.zoom_max_help', ['max' => Map::MAX_ZOOM, 'default' => 5]),
                'zoom_initial' => __('maps/explorer.settings.zoom_initial'),
                'zoom_initial_help' => __('maps/explorer.settings.zoom_initial_help', ['min' => $minInitial, 'max' => $maxInitial, 'default' => $defaultInitial]),
                'distance_name' => __('maps/explorer.settings.distance_name'),
                'distance_measure' => __('maps/explorer.settings.distance_measure'),
                'distance_measure_help' => __('maps/explorer.settings.distance_measure_help'),
                'center' => __('maps/explorer.settings.center'),
                'center_coordinates' => __('maps/explorer.settings.center_coordinates'),
                'center_marker' => __('maps/explorer.settings.center_marker'),
                'pick_on_map' => __('maps/explorer.settings.pick_on_map'),
                'picking' => __('maps/explorer.settings.picking'),
                'no_marker' => __('maps/explorer.settings.no_marker'),
                'legacy_pins' => __('maps/explorer.settings.legacy_pins'),
                'legacy_pins_help' => __('maps/explorer.settings.legacy_pins_help'),
                'save' => __('maps/explorer.settings.save'),
                'error_save' => __('maps/explorer.settings.error_save'),
            ],
            'presence' => [
                'role_edit' => __('maps/explorer.presence.role_edit'),
                'role_view' => __('maps/explorer.presence.role_view'),
                'error_unavailable' => __('maps/explorer.presence.error_unavailable'),
                'error_connecting' => __('maps/explorer.presence.error_connecting'),
                'error_disconnected' => __('maps/explorer.presence.error_disconnected'),
            ],
        ];
    }
}

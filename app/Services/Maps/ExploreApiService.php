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
            'groups' => GroupResource::collection(
                $this->map->groups()->orderBy('position')->orderBy('name')->get()
            ),
            'pins' => $this->map->markers
                ->filter(fn ($marker) => $marker->visible())
                ->values()
                ->map(fn ($marker) => new PinResource($marker)->campaign($this->campaign)->mapEntity($mapEntity))
                ->all(),
            'visibilities' => $this->visibilityOptions(),
            'default_visibility_id' => $this->hasUser() ? $this->campaign->defaultVisibility()->value : null,
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
        if (! $this->hasUser()) {
            return [];
        }

        $options = [
            ['id' => Visibility::All->value, 'name' => __('crud.visibilities.all')],
        ];

        if ($this->user->can('admin', $this->campaign)) {
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
        $settingsZoomLimits = config('limits.maps.zoom.default');
        $initialZoomLimits = $settingsZoomLimits;
        $minInitial = $initialZoomLimits['min'];
        $maxInitial = $initialZoomLimits['max'];
        $defaultInitial = 0;

        if ($this->map->isReal()) {
            $settingsZoomLimits = config('limits.maps.zoom.real');
            $initialZoomLimits = $settingsZoomLimits;
            $minInitial = $initialZoomLimits['min'];
            $maxInitial = $initialZoomLimits['max'];
            $defaultInitial = 12;
        }

        if ($this->map->isTiled()) {
            $initialZoomLimits = config('limits.maps.zoom.tile');
            $minInitial = $initialZoomLimits['min'];
            $maxInitial = $initialZoomLimits['max'];
            $defaultInitial = $minInitial;
        }

        return [
            'legend_title' => __('maps.panels.legend'),
            'legend_search' => __('maps/explorer.legend.search'),
            'legend_expand' => __('maps/explorer.legend.expand'),
            'legend_collapse' => __('maps/explorer.legend.collapse'),
            'layers_base' => __('maps/layers.base'),
            'groups_label' => __('maps.panels.groups'),
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
            'from_entry' => __('maps/markers.details.from-entity'),
            'linked_entry' => __('maps/explorer.marker.linked_entry'),
            'explore_map' => __('maps.actions.explore_named'),
            'description' => __('fields.description.label'),
            'add_description' => __('maps/explorer.marker.add_description'),
            'edit_description' => __('crud.edit'),
            'description_expand' => __('maps/explorer.marker.description_expand'),
            'cancel' => __('crud.cancel'),
            'edit_marker' => __('crud.edit'),
            'center' => __('maps/explorer.marker.center'),
            'duplicate' => __('maps/explorer.marker.duplicate'),
            'delete_marker' => __('maps/explorer.marker.delete'),
            'delete_confirm' => __('maps/explorer.marker.delete_confirm'),
            'new_pin' => __('maps/explorer.marker.new_pin'),
            'name_placeholder' => __('maps/explorer.marker.name_placeholder'),
            'save' => __('crud.save'),
            'save_changes' => __('crud.actions.save-changes'),
            'save_continue' => __('maps/explorer.marker.save_continue'),
            'rapid_active_hint' => __('maps/explorer.marker.rapid_active_hint'),
            'details' => __('maps/explorer.marker.details'),
            'less' => __('maps/explorer.marker.less'),
            'shape' => __('maps/explorer.marker.shape'),
            'templates' => __('entities.templates'),
            'save_current' => __('maps/explorer.marker.save_current'),
            'new_template' => __('maps/explorer.marker.new_template'),
            'untitled_template' => __('maps/explorer.marker.untitled_template'),
            'name' => __('crud.fields.name'),
            'template_name_placeholder' => __('maps/explorer.marker.template_name_placeholder'),
            'create_template' => __('maps/explorer.marker.create_template'),
            'error_save_template' => __('maps/explorer.marker.error_save_template'),
            'error_template_name_required' => __('maps/explorer.marker.error_template_name_required'),
            'manage' => __('maps/explorer.marker.manage'),
            'done' => __('general.done'),
            'edit_template' => __('maps/explorer.marker.edit_template'),
            'delete_template' => __('maps/explorer.marker.delete_template'),
            'error_delete_template' => __('maps/explorer.marker.error_delete_template'),
            'group' => __('maps/explorer.marker.group'),
            'none' => __('maps/explorer.marker.none'),
            'visibility' => __('crud.fields.visibility'),
            'colour' => __('crud.fields.colour'),
            'border_colour' => __('maps/explorer.marker.border_colour'),
            'stroke_width' => __('maps/explorer.marker.stroke_width'),
            'stroke_thin' => __('maps/explorer.marker.stroke_thin'),
            'stroke_normal' => __('maps/explorer.marker.stroke_normal'),
            'stroke_bold' => __('maps/explorer.marker.stroke_bold'),
            'opacity' => __('maps/markers.fields.opacity'),
            'custom' => __('maps/markers.circle_sizes.custom'),
            'premium_custom_icon' => __('maps/explorer.marker.premium_custom_icon'),
            'custom_icon_or_svg' => __('maps/explorer.marker.custom_icon_or_svg'),
            'custom_icon_helper' => __('maps/markers.helpers.custom_icon_v2', [
                'fontawesome' => '<a href="' . config('fontawesome.search') . '" target="_blank" rel="noopener noreferrer" class="text-link">Font Awesome</a>',
                'rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/" target="_blank" rel="noopener noreferrer" class="text-link">RPG Awesome</a>',
                'docs' => '<a href="https://docs.kanka.io/en/latest/entries/maps/markers.html#custom-icon" target="_blank" rel="noopener noreferrer" class="text-link">' . __('footer.documentation') . '</a>',
            ]),
            'custom_icon_placeholder' => __('maps/markers.placeholders.custom_icon', [
                'example1' => '"fa-solid fa-gem"',
                'example2' => '"ra ra-aura"',
            ]),
            'markers_count_one' => __('maps/explorer.markers_count.one'),
            'markers_count_other' => __('maps/explorer.markers_count.other'),
            'peek_map' => __('maps/explorer.marker.peek_map'),
            'peek_panel' => __('maps/explorer.marker.peek_panel'),
            'advanced' => __('maps/explorer.marker.advanced'),
            'is_draggable' => __('maps/markers.fields.is_draggable'),
            'is_draggable_help' => __('maps/explorer.marker.is_draggable_help'),
            'css_class' => __('maps/explorer.marker.css_class'),
            'css_class_help' => __('maps/markers.helpers.css'),
            'new_group' => __('maps/explorer.group.new_group'),
            'untitled_group' => __('maps/explorer.group.untitled_group'),
            'group_name_placeholder' => __('maps/explorer.group.name_placeholder'),
            'parent_group' => __('maps/explorer.group.parent_group'),
            'top_level' => __('maps/explorer.group.top_level'),
            'placement' => __('maps/explorer.group.placement'),
            'placement_first' => __('maps/groups.placeholders.position'),
            'placement_after' => __('maps/groups.placeholders.position_list'),
            'show_group_marker' => __('maps/groups.fields.is_shown'),
            'show_group_marker_help' => __('maps/groups.hints.is_shown'),
            'create_group' => __('maps/explorer.group.create_group'),
            'add_group' => __('maps/explorer.group.add_group'),
            'error_save_group' => __('maps/explorer.group.error_save_group'),
            'error_group_name_required' => __('maps/explorer.group.error_group_name_required'),
            'toolbar' => [
                'rapid' => __('maps/explorer.toolbar.rapid'),
                'rapid_hint' => __('maps/explorer.toolbar.rapid_hint'),
                'pin' => __('maps/markers.tabs.marker'),
                'text' => __('maps/markers.tabs.label'),
                'area' => __('maps/markers.tabs.area'),
                'circle' => __('maps/markers.tabs.circle'),
                'path' => __('maps/markers.tabs.path'),
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
                'settings' => __('maps.panels.settings'),
                'edit' => __('maps.actions.edit'),
            ],
            'settings' => [
                'title' => __('maps/explorer.settings.title'),
                'grid' => __('maps.fields.grid'),
                'grid_help' => __('maps.helpers.grid'),
                'zoom_min' => __('maps.fields.min_zoom'),
                'zoom_min_help' => __('maps.helpers.min_zoom', ['min' => $settingsZoomLimits['min'], 'default' => -2]),
                'zoom_min_value' => $this->map->isTiled() ? null : $settingsZoomLimits['min'],
                'zoom_max' => __('maps.fields.max_zoom'),
                'zoom_max_help' => __('maps.helpers.max_zoom', ['max' => $settingsZoomLimits['max'], 'default' => 5]),
                'zoom_max_value' => $this->map->isTiled() ? null : $settingsZoomLimits['max'],
                'zoom_initial' => __('maps.fields.initial_zoom'),
                'zoom_initial_help' => __('maps.helpers.initial_zoom', ['min' => $minInitial, 'max' => $maxInitial, 'default' => $defaultInitial]),
                'distance_name' => __('maps.fields.distance_name'),
                'distance_measure' => __('maps.fields.distance_measure'),
                'distance_measure_help' => __('maps.helpers.distance_measure') . __('maps.helpers.distance_measure_2'),
                'center' => __('maps/explorer.settings.center'),
                'center_coordinates' => __('maps.fields.tabs.coordinates'),
                'center_marker' => __('maps.fields.center_marker'),
                'pick_on_map' => __('maps/explorer.settings.pick_on_map'),
                'picking' => __('maps/explorer.settings.picking'),
                'no_marker' => __('maps/explorer.settings.no_marker'),
                'legacy_pins' => __('maps/explorer.settings.legacy_pins'),
                'legacy_pins_help' => __('maps/explorer.settings.legacy_pins_help'),
                'save' => __('crud.save'),
                'error_save' => __('maps/explorer.settings.error_save'),
            ],
            'presence' => [
                'role_edit' => __('maps/explorer.presence.role_edit'),
                'role_view' => __('campaigns.members.roles.viewer'),
                'error_unavailable' => __('maps/explorer.presence.error_unavailable'),
                'error_connecting' => __('maps/explorer.presence.error_connecting'),
                'error_disconnected' => __('maps/explorer.presence.error_disconnected'),
            ],
        ];
    }
}

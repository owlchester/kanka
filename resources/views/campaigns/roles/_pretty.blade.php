<?php
/**
 * @var \App\Services\Permissions\RolePermissionService $permissionService
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\Campaign $campaign
 */

$actionMeta = [
    [
        'id' => \App\Models\CampaignPermission::ACTION_READ,
        'label' => __('campaigns.roles.permissions.actions.read'),
        'icon' => 'fa-regular fa-eye',
    ],
    [
        'id' => \App\Models\CampaignPermission::ACTION_EDIT,
        'label' => __('campaigns.roles.permissions.actions.edit'),
        'icon' => 'fa-regular fa-pen',
    ],
    [
        'id' => \App\Models\CampaignPermission::ACTION_ADD,
        'label' => __('campaigns.roles.permissions.actions.add'),
        'icon' => 'fa-regular fa-plus-square',
    ],
    [
        'id' => \App\Models\CampaignPermission::ACTION_DELETE,
        'label' => __('campaigns.roles.permissions.actions.delete'),
        'icon' => 'fa-regular fa-trash-alt',
    ],
    [
        'id' => \App\Models\CampaignPermission::ACTION_POSTS,
        'label' => __('campaigns.roles.permissions.actions.articles'),
        'icon' => 'fa-regular fa-file',
    ],
    [
        'id' => \App\Models\CampaignPermission::ACTION_PERMS,
        'label' => __('campaigns.roles.permissions.actions.permission'),
        'icon' => 'fa-regular fa-cog',
    ],
];

$categoryItems = [];
foreach ($permissionService->permissions() as $entry) {
    /** @var \App\Models\EntityType $entityType */
    $entityType = $entry['entityType'];
    $permsMap = [];
    foreach ($entry['permissions'] as $perm) {
        $permsMap[(int) $perm['action']] = (bool) $perm['enabled'];
    }

    $categoryItems[] = [
        'id' => (int) $entityType->id,
        'name' => $entityType->plural(),
        'icon' => $entityType->icon(),
        'disabled' => ($entityType->isCustom() && ! $entityType->isEnabled())
            || ($entityType->isStandard() && ! $campaign->enabled($entityType->pluralCode())),
        'perms' => $permsMap,
    ];
}

$featureGroups = [];

$campaignItems = [];
foreach ($permissionService->campaignPermissions() as $entity => $perms) {
    foreach ($perms as $perm) {
        $campaignItems[] = [
            'key' => $perm['key'],
            'entity' => $entity,
            'label' => __('campaigns.roles.permissions.actions.' . $perm['label']),
            'description' => __('campaigns.roles.permissions.helpers.' . $perm['label']),
            'icon' => $perm['icon'],
            'enabled' => (bool) $perm['enabled'],
        ];
    }
}
$featureGroups[] = [
    'title' => __('campaigns/roles.standard.features.groups.campaign'),
    'items' => $campaignItems,
];

$galleryItems = [];
foreach ($permissionService->galleryPermissions() as $entity => $perms) {
    foreach ($perms as $perm) {
        $galleryItems[] = [
            'key' => $perm['key'],
            'entity' => $entity,
            'label' => __('campaigns.roles.permissions.actions.' . $perm['label']),
            'description' => __('campaigns.roles.permissions.helpers.' . $perm['label']),
            'icon' => $perm['icon'],
            'enabled' => (bool) $perm['enabled'],
        ];
    }
}
$featureGroups[] = [
    'title' => __('campaigns/roles.standard.features.groups.gallery'),
    'items' => $galleryItems,
];

$templateItems = [];
foreach ($permissionService->templatePermissions() as $entity => $perms) {
    foreach ($perms as $perm) {
        $descKey = $perm['label'] === 'articles'
            ? 'campaigns/roles.standard.features.helpers.template_articles'
            : 'campaigns/roles.standard.features.helpers.template_entries';
        $templateItems[] = [
            'key' => $perm['key'],
            'entity' => $entity,
            'label' => __('entities.' . $perm['label']),
            'description' => __($descKey),
            'icon' => $perm['icon'],
            'enabled' => (bool) $perm['enabled'],
        ];
    }
}
$featureGroups[] = [
    'title' => __('campaigns/roles.standard.features.groups.templates'),
    'items' => $templateItems,
];

$bookmarkItems = [];
foreach ($permissionService->bookmarkPermissions() as $entity => $perms) {
    foreach ($perms as $perm) {
        $bookmarkItems[] = [
            'key' => $perm['key'],
            'entity' => $entity,
            'label' => __('campaigns.roles.permissions.actions.' . $perm['label']),
            'description' => __('campaigns/roles.standard.features.helpers.bookmarks'),
            'icon' => $perm['icon'],
            'enabled' => (bool) $perm['enabled'],
        ];
    }
}
$featureGroups[] = [
    'title' => __('campaigns/roles.standard.features.groups.bookmarks'),
    'items' => $bookmarkItems,
];

$initialState = [
    'categories' => $categoryItems,
    'featureGroups' => $featureGroups,
];
?>

<div
    class="w-full flex flex-col gap-6"
    x-data="{
        categories: {{ \Illuminate\Support\Js::from($categoryItems) }},
        featureGroups: {{ \Illuminate\Support\Js::from($featureGroups) }},
        initialSnapshot: {{ \Illuminate\Support\Js::from(json_encode($initialState)) }},
        actions: {{ \Illuminate\Support\Js::from($actionMeta) }},
        showAdvanced: false,
        get activeCategories() {
            return this.categories.filter(c => !c.disabled);
        },
        get disabledCategories() {
            return this.categories.filter(c => c.disabled);
        },
        get hasChanges() {
            return JSON.stringify({
                categories: this.categories,
                featureGroups: this.featureGroups,
            }) !== this.initialSnapshot;
        },
        presetFor(cat) {
            const p = cat.perms;
            const r = !!p[1], e = !!p[2], a = !!p[3], d = !!p[4], po = !!p[5], pe = !!p[6];
            if (!r && !e && !a && !d && !po && !pe) return 'none';
            if (r && !e && !a && !d && !po && !pe) return 'view';
            if (r && e && a && !d && po && !pe) return 'contribute';
            if (r && e && a && d && po && pe) return 'full';
            return 'custom';
        },
        applyPreset(cat, preset) {
            if (preset === 'none') {
                cat.perms = { 1: false, 2: false, 3: false, 4: false, 5: false, 6: false };
            } else if (preset === 'view') {
                cat.perms = { 1: true, 2: false, 3: false, 4: false, 5: false, 6: false };
            } else if (preset === 'contribute') {
                cat.perms = { 1: true, 2: true, 3: true, 4: false, 5: true, 6: false };
            } else if (preset === 'full') {
                cat.perms = { 1: true, 2: true, 3: true, 4: true, 5: true, 6: true };
            }
        },
        applyPresetAll(preset) {
            const list = preset === 'none' ? this.categories : this.activeCategories;
            list.forEach(cat => this.applyPreset(cat, preset));
        },
        toggleCategoryAction(cat, actionId) {
            cat.perms[actionId] = !cat.perms[actionId];
        },
        toggleFeature(feature) {
            feature.enabled = !feature.enabled;
        },
        reset() {
            const parsed = JSON.parse(this.initialSnapshot);
            this.categories = parsed.categories;
            this.featureGroups = parsed.featureGroups;
        }
    }"
>
    {{-- Content Categories --}}
    <div class="flex flex-col gap-3">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-light">{{ __('campaigns/roles.permissions.content-modules') }}</h2>

            <div class="flex flex-wrap items-center gap-2">
                <span class="text-xs text-neutral-content mr-1">{{ __('campaigns/roles.standard.presets.label') }}:</span>
                <button type="button" class="btn2 btn-xs" @click="applyPresetAll('view')">
                    {{ __('campaigns/roles.standard.presets.view') }}
                </button>
                <button type="button" class="btn2 btn-xs" @click="applyPresetAll('contribute')">
                    {{ __('campaigns/roles.standard.presets.contribute') }}
                </button>
                <button type="button" class="btn2 btn-xs" @click="applyPresetAll('full')">
                    {{ __('campaigns/roles.standard.presets.full') }}
                </button>
                <button type="button" class="btn2 btn-xs btn-ghost" @click="applyPresetAll('none')">
                    {{ __('campaigns/roles.standard.presets.clear_all') }}
                </button>
                <button
                    type="button"
                    role="switch"
                    :aria-checked="showAdvanced ? 'true' : 'false'"
                    @click="showAdvanced = !showAdvanced"
                    class="btn2 btn-xs ml-1"
                    :class="showAdvanced ? 'btn-primary' : 'btn-ghost'"
                >
                    <x-icon class="fa-regular fa-sliders" />
                    {{ __('campaigns/roles.standard.advanced.toggle') }}
                </button>
            </div>
        </div>

        <div class="bg-base-100 rounded-xl shadow-xs divide-y divide-base-200">
            <template x-for="cat in activeCategories" :key="cat.id">
                <div class="p-3.5 flex flex-col gap-2.5">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span
                                class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center text-base transition-colors"
                                :class="presetFor(cat) === 'none' ? 'bg-base-200 text-neutral-content' : 'bg-primary/15 text-primary'"
                            >
                                <i :class="cat.icon" aria-hidden="true"></i>
                            </span>
                            <span class="font-medium truncate" x-text="cat.name"></span>
                        </div>

                        <select
                            class="text-sm rounded-lg border border-base-300 bg-base-100 px-2.5 py-1.5 shrink-0"
                            :aria-label="cat.name"
                            :value="presetFor(cat)"
                            @change="applyPreset(cat, $event.target.value)"
                        >
                            <option value="none">{{ __('campaigns/roles.standard.presets.none') }}</option>
                            <option value="view">{{ __('campaigns/roles.standard.presets.view') }}</option>
                            <option value="contribute">{{ __('campaigns/roles.standard.presets.contribute') }}</option>
                            <option value="full">{{ __('campaigns/roles.standard.presets.full') }}</option>
                            <option value="custom" x-show="presetFor(cat) === 'custom'">{{ __('campaigns/roles.standard.presets.custom') }}</option>
                        </select>
                    </div>

                    <div x-show="showAdvanced" x-cloak class="flex flex-wrap gap-1.5 pl-12">
                        <template x-for="action in actions" :key="action.id">
                            <button
                                type="button"
                                @click="toggleCategoryAction(cat, action.id)"
                                :aria-pressed="cat.perms[action.id] ? 'true' : 'false'"
                                :class="cat.perms[action.id]
                                    ? 'bg-primary/15 text-primary ring-1 ring-primary/40 font-medium'
                                    : 'bg-base-200 text-neutral-content hover:bg-base-300/60'"
                                class="text-xs px-2.5 py-1 rounded-lg cursor-pointer flex items-center gap-1.5 transition-colors"
                            >
                                <i :class="action.icon" aria-hidden="true"></i>
                                <span x-text="action.label"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <template x-if="disabledCategories.length > 0">
            <details class="group/disabled">
                <summary class="list-none cursor-pointer flex items-center gap-2 text-sm text-neutral-content hover:text-base-content select-none py-1">
                    <x-icon class="fa-solid fa-chevron-right text-xs transition-transform group-open/disabled:rotate-90" />
                    <span x-text="`{{ __('campaigns/roles.public.disabled_categories.title', ['count' => '__COUNT__']) }}`.replace('__COUNT__', disabledCategories.length)"></span>
                </summary>
                <div class="mt-2 flex flex-col gap-2">
                    <p class="text-sm text-neutral-content">
                        {{ __('campaigns/roles.public.disabled_categories.helper') }}
                    </p>
                    <div class="bg-base-100 rounded-xl shadow-xs divide-y divide-base-200 opacity-75">
                        <template x-for="cat in disabledCategories" :key="cat.id">
                            <div class="p-3.5 flex flex-col gap-2.5">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center text-base transition-colors"
                                            :class="presetFor(cat) === 'none' ? 'bg-base-200 text-neutral-content' : 'bg-primary/15 text-primary'"
                                        >
                                            <i :class="cat.icon" aria-hidden="true"></i>
                                        </span>
                                        <span class="font-medium truncate" x-text="cat.name"></span>
                                    </div>

                                    <select
                                        class="text-sm rounded-lg border border-base-300 bg-base-100 px-2.5 py-1.5 shrink-0"
                                        :aria-label="cat.name"
                                        :value="presetFor(cat)"
                                        @change="applyPreset(cat, $event.target.value)"
                                    >
                                        <option value="none">{{ __('campaigns/roles.standard.presets.none') }}</option>
                                        <option value="view">{{ __('campaigns/roles.standard.presets.view') }}</option>
                                        <option value="contribute">{{ __('campaigns/roles.standard.presets.contribute') }}</option>
                                        <option value="full">{{ __('campaigns/roles.standard.presets.full') }}</option>
                                        <option value="custom" x-show="presetFor(cat) === 'custom'">{{ __('campaigns/roles.standard.presets.custom') }}</option>
                                    </select>
                                </div>

                                <div x-show="showAdvanced" x-cloak class="flex flex-wrap gap-1.5 pl-12">
                                    <template x-for="action in actions" :key="action.id">
                                        <button
                                            type="button"
                                            @click="toggleCategoryAction(cat, action.id)"
                                            :aria-pressed="cat.perms[action.id] ? 'true' : 'false'"
                                            :class="cat.perms[action.id]
                                                ? 'bg-primary/15 text-primary ring-1 ring-primary/40 font-medium'
                                                : 'bg-base-200 text-neutral-content hover:bg-base-300/60'"
                                            class="text-xs px-2.5 py-1 rounded-lg cursor-pointer flex items-center gap-1.5 transition-colors"
                                        >
                                            <i :class="action.icon" aria-hidden="true"></i>
                                            <span x-text="action.label"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </details>
        </template>
    </div>

    {{-- Campaign Features --}}
    <div class="flex flex-col gap-4">
        <h2 class="text-xl font-light">{{ __('campaigns/roles.permissions.campaign-features') }}</h2>

        <template x-for="group in featureGroups" :key="group.title">
            <div class="flex flex-col gap-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-neutral-content" x-text="group.title"></span>
                <div class="grid gap-3 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    <template x-for="feature in group.items" :key="feature.key">
                        <button
                            type="button"
                            role="switch"
                            :aria-checked="feature.enabled ? 'true' : 'false'"
                            @click="toggleFeature(feature)"
                            class="group bg-base-100 hover:bg-base-200/60 rounded-xl p-3.5 shadow-xs flex items-center justify-between gap-3 text-left cursor-pointer transition-all ring-1 ring-transparent aria-checked:ring-primary/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary"
                        >
                            <span class="flex items-start gap-3 min-w-0">
                                <span class="w-9 h-9 rounded-lg shrink-0 flex items-center justify-center text-base transition-colors bg-base-200 text-neutral-content group-aria-checked:bg-primary/15 group-aria-checked:text-primary mt-0.5">
                                    <i :class="feature.icon" aria-hidden="true"></i>
                                </span>
                                <span class="min-w-0">
                                    <span class="block font-medium text-sm text-base-content" x-text="feature.label"></span>
                                    <span class="block text-xs text-neutral-content line-clamp-2" x-text="feature.description"></span>
                                </span>
                            </span>

                            <span aria-hidden="true" class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full bg-base-300 transition-colors group-aria-checked:bg-primary">
                                <span class="inline-block h-4 w-4 translate-x-1 rounded-full bg-base-100 shadow-xs transition-transform group-aria-checked:translate-x-6"></span>
                            </span>
                        </button>
                    </template>
                </div>
            </div>
        </template>
    </div>

    {{-- Hidden inputs synced for savePermissions --}}
    <div class="hidden" aria-hidden="true">
        <template x-for="cat in categories" :key="'input-' + cat.id">
            <div>
                <template x-for="action in actions" :key="'input-' + cat.id + '-' + action.id">
                    <template x-if="cat.perms[action.id]">
                        <input type="hidden" :name="`permissions[${cat.id}_${action.id}]`" :value="cat.id" />
                    </template>
                </template>
            </div>
        </template>

        <template x-for="group in featureGroups" :key="'input-group-' + group.title">
            <div>
                <template x-for="feature in group.items" :key="'input-feat-' + feature.key">
                    <template x-if="feature.enabled">
                        <input type="hidden" :name="`permissions[${feature.key}]`" :value="feature.entity" />
                    </template>
                </template>
            </div>
        </template>
    </div>

    {{-- Sticky Save Bar --}}
    <div class="sticky bottom-4 z-40">
        <div
            class="bg-base-100 rounded-xl shadow-md px-4 py-3 flex flex-wrap items-center justify-between gap-3 ring-1 transition-all"
            :class="hasChanges ? 'ring-primary/50' : 'ring-base-200'"
        >
            <div class="flex items-center gap-2 text-sm">
                <span x-show="hasChanges" x-cloak class="flex items-center gap-2 text-primary font-medium">
                    <span class="w-2 h-2 rounded-full bg-primary inline-block"></span>
                    {{ __('campaigns/roles.standard.save_bar.unsaved') }}
                </span>
                <span x-show="!hasChanges" class="text-neutral-content">
                    {{ __('campaigns.roles.hints.role_permissions', ['name' => $role->name]) }}
                </span>
            </div>

            <div class="flex items-center gap-2 ml-auto">
                <button type="button" class="btn2 btn-sm btn-ghost" x-show="hasChanges" x-cloak @click="reset()">
                    {{ __('campaigns/roles.standard.save_bar.reset') }}
                </button>
                <button type="submit" class="btn2 btn-primary">
                    <x-icon class="save" />
                    {{ __('crud.save') }}
                </button>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\Models\PostPermission $perm
 * @var \App\Models\Post $model
 */

use App\Models\PostLayout;

$permissions = [
    0 => __('crud.view'),
    1 => __('crud.edit'),
    2 => __('crud.permissions.actions.bulk.deny')
];
$defaultCollapsed = null;
if (!isset($model) && !empty($campaign->ui_settings['post_collapsed'])) {
    $defaultCollapsed = 1;
}
if (isset($model)) {
    $hideLayout = 1;
    if ($model->layout_id) {
        $layoutHelper = __('post_layouts.helper', ['subpage' => $model->layout->name()]);
    }
}

$options = $entity->postPositionOptions(!empty($model->position) ? $model->position : null);
if (isset($template)) {
    $model = $template;
    $model->name = '';
    $model->position = null;
}
$last = array_key_last($options);

$bragiName = $entity->isCharacter() ? $entity->name : null;
$layouts = PostLayout::entity($entity->type_id)->get();
$layoutDefault = ['' => __('crud.fields.entry')];

foreach($layouts as $layout) {
    $layoutOptions[$layout->id] = $layout->name();
}

$collator = new \Collator(app()->getLocale());
$collator->asort($layoutOptions);

$layoutOptions = $layoutDefault + $layoutOptions
?>
<div class="nav-tabs-custom">
    <div class="flex gap-2 items-center ">
        <div class="grow overflow-x-auto">
            <ul class="nav-tabs flex items-stretch w-full" role="tablist">
                <x-tab.tab target="entry" :default="true" :title="__('crud.fields.entry')"></x-tab.tab>
                @can('permissions', $entity)
                    <x-tab.tab target="permissions" :title="__('entities/notes.show.advanced')"></x-tab.tab>
                @endcan
                @if (auth()->user()->can('useTemplates', $campaign) && !empty($templates))
                    <x-tab.tab target="templates" :title="__('entities/attributes.template.load.title')"></x-tab.tab>
                @endif
            </ul>
        </div>
        @include('entities.pages.posts._save-options')
    </div>
    <div class="tab-content bg-base-100 p-4 rounded-bl rounded-br">
        <div class="tab-pane pane-entry active" id="form-entry">
            <x-grid>
                <x-forms.field field="name" required>
                    <input type="text" name="name"  placeholder="{{ __('entities/notes.placeholders.name') }}"
                           value="{!! htmlspecialchars(old('name', str_replace('&amp;', '&', $model->name ?? ''))) !!}"
                           maxlength="191" data-bragi-name="{{ $bragiName }}" data-live-disabled="1" data-1p-ignore="true" />
                </x-forms.field>

                <x-forms.field field="layout" :hidden="isset($layoutHelper)">
                    <x-forms.select name="layout_id" :options="$layoutOptions" :selected="$source->layout_id ?? $model->layout_id ?? null"  id="post-layout-selector" />
                    <div id="post-layout-subform" style="display: none">
                        @includeWhen(!$campaign->superboosted(), 'entities.pages.posts._boosted')
                    </div>
                </x-forms.field>

                @if (isset($layoutHelper))
                    <p class="text-neutral-content m-0">{{ $layoutHelper }}</p>
                @endif

                <x-forms.field field="entry" css="md:col-span-2" id="field-entry" :hidden="isset($layoutHelper)">
                    <textarea name="entry"
                              id="entry"
                              class="html-editor"
                              rows="3"
                    >{!! old('entry', $model->entryForEdition ?? null) !!}</textarea>
                </x-forms.field>
                <x-forms.field field="location" id="field-location" :hidden="isset($layoutHelper)">
                    @include('cruds.fields.location', ['from' => null])
                </x-forms.field>
                <x-forms.field field="tags">
                    <input type="hidden" name="save_tags" value="1" />
                    <x-forms.tags
                        :campaign="$campaign"
                        :model="$model ?? null">
                    </x-forms.tags>
                </x-forms.field>

                @include('cruds.fields.visibility_id')

                <x-forms.field field="position" :label="__('crud.fields.position')">
                    <x-forms.select name="position" :options="$options" :selected="(!empty($model->position) ? -9999 : $last)" class="w-full" />
                </x-forms.field>
                @php
                    $collapsedOptions = [
                        0 => __('entities/notes.collapsed.open'),
                        1 => __('entities/notes.collapsed.closed')
                    ];
                @endphp
                <x-forms.field field="display" id="field-display" :hidden="isset($layoutHelper)" :label="__('entities/notes.fields.display')">
                    <x-forms.select name="settings[collapsed]" :options="$collapsedOptions" :selected="$model?->collapsed() ?? $defaultCollapsed" class="w-full" />
                </x-forms.field>

                <x-forms.field field="class" :label=" __('dashboard.widgets.fields.class')" tooltip :helper="__('dashboard.widgets.helpers.class')">
                    <input type="text" name="settings[class]" value="{{ old('settings[class]', $model->settings['class'] ?? null) }}" maxlength="191" @if (!$campaign->boosted()) disabled="disabled" @endif class="w-full" id="config[class]" />
                    @includeWhen(!$campaign->boosted(), 'entities.pages.posts._boosted')
                </x-forms.field>
            </x-grid>
        </div>
        @includeWhen(auth()->user()->can('permissions', $entity), 'entities.pages.posts._permissions')
        @includeWhen(auth()->user()->can('useTemplates', $campaign) && !empty($templates), 'entities.pages.posts._templates')
    </div>
</div>

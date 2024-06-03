<?php
/**
 * @var \App\Models\PostPermission $perm
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
                @can('permission', $entity->child)
                    <x-tab.tab target="permissions" :title="__('entities/notes.show.advanced')"></x-tab.tab>
                @endcan
            </ul>
        </div>
        @include('entities.pages.posts._save-options')
    </div>
    <div class="tab-content bg-base-100 p-4 rounded-bl rounded-br">
        <div class="tab-pane pane-entry active" id="form-entry">
            <x-grid>
                <x-forms.field field="name" :required="true">
                    {!! Form::text('name', null, ['placeholder' => __('entities/notes.placeholders.name'), 'class' => '', 'maxlength' => 191, 'data-live-disabled' => '1', 'required', 'data-bragi-name' => $bragiName]) !!}
                </x-forms.field>

                <x-forms.field field="layout" :hidden="isset($layoutHelper)">
                    {!! Form::select('layout_id', $layoutOptions, isset($model) ? $model->layout_id : '',['class' => '', 'id' => 'post-layout-selector']) !!}
                    <div id="post-layout-subform" style="display: none">
                        @includeWhen(!$campaign->superboosted(), 'entities.pages.posts._boosted')
                    </div>
                </x-forms.field>
                @if (isset($layoutHelper))
                    <p class="text-neutral-content m-0">{{ $layoutHelper }}</p>
                @endif

                <x-forms.field field="entry" css="md:col-span-2" id="field-entry" :hidden="isset($layoutHelper)">
                    {!! Form::textarea('entryForEdition', null, ['class' => ' html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
                </x-forms.field>
                <x-forms.field field="location" id="field-location" :hidden="isset($layoutHelper)">
                    @include('cruds.fields.location', ['from' => null])
                </x-forms.field>

                @include('cruds.fields.visibility_id')

                <x-forms.field field="position" :label="__('crud.fields.position')">
                    {!! Form::select('position', $options, (!empty($model->position) ? -9999 : $last), ['class' => '']) !!}
                </x-forms.field>
                @php
                    $collapsedOptions = [
                        0 => __('entities/notes.collapsed.open'),
                        1 => __('entities/notes.collapsed.closed')
                    ];
                @endphp
                <x-forms.field field="display" id="field-display" :hidden="isset($layoutHelper)" :label="__('entities/notes.fields.display')">
                    {!! Form::select('settings[collapsed]', $collapsedOptions, $defaultCollapsed, ['class' => '']) !!}
                </x-forms.field>

                <x-forms.field field="class" :label=" __('dashboard.widgets.fields.class')" :tooltip="true" :helper="__('dashboard.widgets.helpers.class')">
                    {!! Form::text('settings[class]', null, ['class' => '', 'id' => 'config[class]', 'disabled' => !$campaign->boosted() ? 'disabled' : null]) !!}
                    @includeWhen(!$campaign->boosted(), 'entities.pages.posts._boosted')
                </x-forms.field>
            </x-grid>
        </div>

        @includeWhen(auth()->user()->can('permission', $entity->child), 'entities.pages.posts._permissions')
    </div>
</div>

<input type="hidden" name="entity_id" value="{{ $entity->id }}" />

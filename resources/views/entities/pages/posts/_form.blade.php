<?php
/**
 * @var \App\Models\EntityNotePermission $perm
 */

use App\Models\PostLayout;

$permissions = [
    0 => __('crud.view'),
    1 => __('crud.edit'),
    2 => __('crud.permissions.actions.bulk.deny')
];
$currentCampaign = \App\Facades\CampaignLocalization::getCampaign();
$defaultCollapsed = null;
if (!isset($model) && !empty($currentCampaign->ui_settings['post_collapsed'])) {
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
                <div class="field-name required">
                    {!! Form::text('name', null, ['placeholder' => __('entities/notes.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191, 'data-live-disabled' => '1', 'required', 'data-bragi-name' => $bragiName]) !!}
                </div>
                <div class="field-layout" @if(isset($hideLayout)) style="display: none" @endif>
                    {!! Form::select('layout_id', $layoutOptions, isset($model) ? $model->layout_id : '',['class' => 'form-control', 'id' => 'post-layout-selector']) !!}
                    <div id="post-layout-subform" style="display: none">
                        @includeWhen(!$currentCampaign->superboosted(), 'entities.pages.posts._boosted')
                    </div>
                </div>
                @if (isset($layoutHelper))
                    <div class="field-layout-helper">
                        <p class="help-block">{{ $layoutHelper }}</p>
                    </div>
                @endif
                <div class="field-entry md:col-span-2" id="field-entry" @if(isset($layoutHelper)) style="display: none" @endif>
                    {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
                </div>
                <div class="field-location" id="field-location" @if(isset($layoutHelper)) style="display: none" @endif>
                    <input type="hidden" name="location_id" value="" />
                    @include('cruds.fields.location', ['from' => null])
                </div>

                @include('cruds.fields.visibility_id')

                <div class="field-position">
                    <label>{{ __('crud.fields.position') }}</label>
                    {!! Form::select('position', $options, (!empty($model->position) ? -9999 : $last), ['class' => 'form-control']) !!}
                </div>
                @php
                    $collapsedOptions = [
                        0 => __('entities/notes.collapsed.open'),
                        1 => __('entities/notes.collapsed.closed')
                    ];
                @endphp
                <div class="field-display" id="field-display" @if(isset($layoutHelper)) style="display: none" @endif>
                    <label>
                        {{ __('entities/notes.fields.display') }}
                    </label>
                    {!! Form::select('settings[collapsed]', $collapsedOptions, $defaultCollapsed, ['class' => 'form-control']) !!}
                </div>

                <div class="field-class">
                    <label for="config[class]">
                        {{ __('dashboard.widgets.fields.class') }}
                        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.helpers.class') }}"></i>
                    </label>
                    {!! Form::text('settings[class]', null, ['class' => 'form-control', 'id' => 'config[class]', 'disabled' => !$currentCampaign->boosted() ? 'disabled' : null]) !!}
                    <p class="help-block visible-xs visible-sm">
                        {{ __('dashboard.widgets.helpers.class') }}
                    </p>
                    @includeWhen(!$currentCampaign->boosted(), 'entities.pages.posts._boosted')
                </div>
            </x-grid>
        </div>

        @includeWhen(auth()->user()->can('permission', $entity->child), 'entities.pages.posts._permissions')
    </div>
</div>

{!! Form::hidden('entity_id', $entity->id) !!}

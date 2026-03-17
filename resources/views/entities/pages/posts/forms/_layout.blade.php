<?php
/**
 * @var \App\Models\Post $model?
 * @var \App\Models\Entity $entity
 */
$collapsedOptions = [
    0 => __('entities/notes.collapsed.open'),
    1 => __('entities/notes.collapsed.closed')
];

$defaultCollapsed = null;
if (!isset($model) && !empty($campaign->ui_settings['post_collapsed'])) {
    $defaultCollapsed = 1;
}
?>

<div class="tab-pane" id="form-layout">
    <x-grid type="1/1">
        <x-forms.field field="display" id="field-display" :hidden="isset($layoutHelper)" :label="__('entities/notes.fields.display')" x-show="!layout">
            <x-forms.select
                name="settings[collapsed]"
                :options="$collapsedOptions"
                :selected="$model?->collapsed() ?? $defaultCollapsed"
                radio
                class="w-full" />
        </x-forms.field>

        <x-forms.field field="class" :label=" __('dashboard.widgets.fields.class')" tooltip :helper="__('dashboard.widgets.helpers.class')">
            <input type="text" name="settings[class]" value="{{ old('settings[class]', $model->settings['class'] ?? null) }}" maxlength="191" @if (!$campaign->boosted()) disabled="disabled" @endif class="w-full" id="config[class]" />
            @includeWhen(!$campaign->boosted(), 'entities.pages.posts._boosted')
        </x-forms.field>
    </x-grid>
</div>

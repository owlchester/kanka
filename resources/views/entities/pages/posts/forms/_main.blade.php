<?php
/**
 * @var \App\Models\Post $model
 */
use App\Models\PostLayout;


$defaultCollapsed = null;
if (!isset($model) && !empty($campaign->ui_settings['post_collapsed'])) {
    $defaultCollapsed = 1;
}
if (isset($model)) {
    $hideLayout = 1;
    if ($model->layout_id) {
        $layoutHelper = true;
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
?>
<div
    class="tab-pane pane-entry active"
    id="form-entry"
    x-data="{ layout: '{{ old('layout_id', $source->layout_id ?? $model->layout_id ?? '') }}' }"
>
    <x-grid type="1/1">
        <x-forms.field field="name" required label="{{ __('posts.fields.name') }}">
            <input type="text" name="name"  placeholder="{{ __('entities/notes.placeholders.name') }}"
                   value="{!! htmlspecialchars(old('name', str_replace('&amp;', '&', $model->name ?? ''))) !!}"
                   maxlength="191" data-bragi-name="{{ $bragiName }}" data-live-disabled="1" data-1p-ignore="true" />
        </x-forms.field>

        @if (isset($layoutOptions))
            <x-forms.field field="layout" label="{{ __('posts.fields.layout') }}">
                <x-forms.select name="layout_id" :options="$layoutOptions" :selected="$source->layout_id ?? $model->layout_id ?? null"  id="post-layout-selector" x-model="layout" :disabled="$disabledLayoutOptions" />

                @if (!$campaign->superboosted())
                    <x-helper>
                        <p class="text-xs">
                            <x-icon class="fa-regular fa-question-circle"></x-icon>
                            {{ __('post_layouts.premium') }}
                            <a
                                href="#"
                                data-toggle="dialog"
                                data-url="{{ route('posts.layouts', [$campaign, $entity]) }}">
                                {{ __('general.learn-more') }}
                            </a>
                        </p>
                    </x-helper>
                @endif
            </x-forms.field>
        @endif

        @if (isset($layoutHelper))
            @php $helper = __('post_layouts.helper', [
        'subpage' => '<span class="font-bold">' . $model->layout->name() . '</span>',
        'name' => $entity->name
        ]); @endphp
            <x-forms.field field="layout" label="{{ __('posts.fields.layout') }}" :helper="$helper">

            </x-forms.field>
        @endif

        <x-forms.field field="entry" id="field-entry" :hidden="isset($layoutHelper)" x-show="!layout">
            @include('cruds.fields.entry', ['model' => $model])
        </x-forms.field>

        <x-grid>
            <x-forms.field field="location" id="field-location" :hidden="isset($layoutHelper)" x-show="!layout">
                @include('cruds.fields.location', ['from' => null])
            </x-forms.field>
            @if (isset($model))
                @include('cruds.forms._calendar', ['post' => $model])
            @else
                @include('cruds.forms._calendar')
            @endif

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
            <x-forms.field field="display" id="field-display" :hidden="isset($layoutHelper)" :label="__('entities/notes.fields.display')" x-show="!layout">
                <x-forms.select name="settings[collapsed]" :options="$collapsedOptions" :selected="$model?->collapsed() ?? $defaultCollapsed" class="w-full" />
            </x-forms.field>

            <x-forms.field field="class" :label=" __('dashboard.widgets.fields.class')" tooltip :helper="__('dashboard.widgets.helpers.class')">
                <input type="text" name="settings[class]" value="{{ old('settings[class]', $model->settings['class'] ?? null) }}" maxlength="191" @if (!$campaign->boosted()) disabled="disabled" @endif class="w-full" id="config[class]" />
                @includeWhen(!$campaign->boosted(), 'entities.pages.posts._boosted')
            </x-forms.field>
        </x-grid>
    </x-grid>
</div>

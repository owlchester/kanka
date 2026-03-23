<?php
/**
 * @var \App\Models\Post $model
 */
use App\Models\PostLayout;


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

            @if (!empty($galleryLayoutId))
                <div x-show="layout == '{{ $galleryLayoutId }}'" x-cloak>
                    <x-forms.foreign
                        :campaign="$campaign"
                        name="settings[folder_id]"
                        :label="__('dashboards/widgets/gallery.fields.folder')"
                        :placeholder="__('crud.select')"
                        :route="route('folders.find', [$campaign])"
                        :allowClear="true"
                    />
                </div>

                <x-forms.field field="gallery-show-name" :label="__('dashboards/widgets/gallery.fields.show_name')" x-show="layout == '{{ $galleryLayoutId }}'" x-cloak>
                    <x-checkbox :text="__('dashboards/widgets/gallery.helpers.show_name')">
                        <input type="checkbox" name="settings[show_name]" value="1"
                            @if (old('settings.show_name', $model->settings['show_name'] ?? false)) checked="checked" @endif />
                    </x-checkbox>
                </x-forms.field>
            @endif
        @endif

        @if (isset($layoutHelper))
            @php $helper = __('post_layouts.helper', [
        'subpage' => '<span class="font-bold">' . $model->layout->name() . '</span>',
        'name' => $entity->name
        ]); @endphp
            <x-forms.field field="layout" label="{{ __('posts.fields.layout') }}" :helper="$helper">

            </x-forms.field>

            @if (!empty($galleryLayoutId) && ($model->layout_id ?? null) == $galleryLayoutId)
                <x-forms.foreign
                    :campaign="$campaign"
                    name="settings[folder_id]"
                    :label="__('dashboards/widgets/gallery.fields.folder')"
                    :placeholder="__('crud.select')"
                    :route="route('folders.find', [$campaign])"
                    :allowClear="true"
                    :selected="$galleryFolder"
                />

                <x-forms.field field="gallery-show-name" :label="__('dashboards/widgets/gallery.fields.show_name')">
                    <x-checkbox :text="__('dashboards/widgets/gallery.helpers.show_name')">
                        <input type="checkbox" name="settings[show_name]" value="1"
                            @if (old('settings.show_name', $model->settings['show_name'] ?? false)) checked="checked" @endif />
                    </x-checkbox>
                </x-forms.field>
            @endif
        @endif

        <x-forms.field field="entry" id="field-entry" :hidden="isset($layoutHelper)" x-show="!layout" :label="__('fields.description.label')">
            @include('cruds.fields.entry', ['model' => $model ?? null])
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

            <x-forms.field field="position" :label="__('crud.fields.position')">
                <x-forms.select name="position" :options="$options" :selected="(!empty($model->position) ? -9999 : $last)" class="w-full" />
            </x-forms.field>

        </x-grid>
    </x-grid>
</div>

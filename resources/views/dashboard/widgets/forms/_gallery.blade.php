@inject('imageModel', 'App\Models\Image')

@php
    $boosted = $campaign->premium();

    $folders = $imageModel::where('campaign_id', $campaign->id)
        ->where('is_folder', true)
        ->orderBy('name', 'asc')
        ->pluck('name', 'id')
        ->prepend(__('crud.select'), '')
        ->toArray();
@endphp

<x-grid>
    <x-forms.field field="gallery-folder" required :label="__('dashboards/widgets/gallery.fields.folder')">
        <x-forms.select name="config[folder_id]" :options="$folders" :selected="old('config.folder_id', $model->config['folder_id'] ?? null)" class="w-full" />
    </x-forms.field>

    <x-forms.field field="gallery-show-name" :label="__('dashboards/widgets/gallery.fields.show_name')">
        <x-checkbox :text="__('dashboards/widgets/gallery.helpers.show_name')">
            <input type="checkbox" name="config[show_name]" value="1" @if (old('config[show_name]', isset($model) ? $model->conf('show_name') : false)) checked="checked" @endif id="config-show-name" />
        </x-checkbox>
    </x-forms.field>

    @include('dashboard.widgets.forms._name')

    @include('dashboard.widgets.forms._width')

    @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
</x-grid>

<x-widgets.forms.advanced>
    @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')
    <x-grid>
        @include('dashboard.widgets.forms._class')
    </x-grid>
</x-widgets.forms.advanced>

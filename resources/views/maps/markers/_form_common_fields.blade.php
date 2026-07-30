<div id="marker-main-fields" class="flex flex-col gap-5 w-full">
    <x-grid>
        <x-forms.field field="name" :label="__('crud.fields.name')">
            <input type="text" name="name" maxlength="191" placeholder="{{ __('maps/markers.placeholders.name') }}" value="{!! htmlspecialchars(old('name', $source->name ?? $model->name ?? null)) !!}" id="name" />
        </x-forms.field>

        @include('cruds.fields.entity')

        @if (!isset($model))
            <div class="md:col-span-2">
                <x-alert type="info">
                    {{ __('maps/markers.hints.entry') }}
                </x-alert>
            </div>
        @else
        <div class="md:col-span-2 {{ ($model->hasEntry() ? 'hidden' : '') }}">
            <a href="#" class="map-marker-entry-click text-link">{{ __('maps/markers.actions.entry') }}</a>
        </div>
        <div class="md:col-span-2 map-marker-entry-entry {{ (!$model->hasEntry() ? 'hidden' : '') }}" style="">
            <x-forms.field field="entry" :label=" __('fields.description.label')">
                @include('cruds.fields.entry', ['model' => $model])
            </x-forms.field>
        </div>
        @endif

        <x-forms.field
            field="css"
            :label="__('dashboard.widgets.fields.class')"
            :helper="__('maps/markers.helpers.css')"
        >
        <input type="text" name="css" value="{{ old('css', $model->css ?? $source->css ?? null) }}" class="w-full"
                maxlength="45" id="css"/>
        <p class="text-neutral-content md:hidden">
            {{ __('maps/markers.helpers.css') }}
        </p>

        </x-forms.field>
        @include('maps.markers.fields.opacity')

        <div class="" id="map-marker-bg-colour" @if((isset($model) && $model->isLabel()) || (isset($source) && $source->isLabel())) style="display: none;"@endif>
            @include('maps.markers.fields.background_colour')
        </div>

        <x-forms.field field="group" :label="__('maps/markers.fields.group')">
            <x-forms.select name="group_id" :options="$map->groupOptions()" :selected="$source->group_id ?? $model->group_id ?? null" id="group_id" />
        </x-forms.field>

        <x-forms.field field="is_popupless" :label="__('maps/markers.fields.popupless')">
            <input type="hidden" name="is_popupless" value="0" />
            <x-checkbox :text="__('maps/markers.helpers.is_popupless')">
                <input type="checkbox" name="is_popupless" value="1" @if ($source->is_popupless ?? old('is_popupless', $model->is_popupless ?? false)) checked="checked" @endif />
            </x-checkbox>
        </x-forms.field>

        @include('cruds.fields.visibility_id')

    </x-grid>

    <x-grid :hidden="!$model && empty($source)">
        <x-forms.field field="latitude" :label="__('maps/markers.fields.latitude')">
            <input type="number" name="latitude" value="{{ \App\Facades\FormCopy::field('latitude')->string() ?: old('latitude', $model->latitude ?? null) }}" id="marker-latitude" step="0.001" />
        </x-forms.field>

        <x-forms.field field="longitude" :label="__('maps/markers.fields.longitude')">
            <input type="number" name="longitude" value="{{ \App\Facades\FormCopy::field('longitude')->string() ?: old('longitude', $model->longitude ?? null) }}" id="marker-longitude" step="0.001" />
        </x-forms.field>
    </x-grid>
</div>

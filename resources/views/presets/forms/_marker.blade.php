@php
$types = [
    1 => __('maps/markers.tabs.marker'),
    2 => __('maps/markers.tabs.label'),
    3 => __('maps/markers.tabs.circle'),
];
@endphp
<x-grid>
    <x-forms.field field="name" required :label=" __('presets.fields.name')">
        <input type="text" name="name" maxlength="191" placeholder="{{ __('presets.placeholders.name') }}" autofocus required value="{!! htmlspecialchars(old('name', $preset->name ?? null)) !!}" />
    </x-forms.field>

    @include('maps.markers.fields.icon', ['fieldname' => 'config[icon]'])
    @include('maps.markers.fields.custom_icon', ['fieldname' => 'config[custom_icon]'])
    @include('maps.markers.fields.pin_size', ['fieldname' => 'config[pin_size]'])
    @include('maps.markers.fields.font_colour', ['fieldname' => 'config[font_colour]'])
    @include('maps.markers.fields.opacity', ['fieldname' => 'config[opacity]'])
    @include('maps.markers.fields.background_colour', ['fieldname' => 'config[colour]'])

    @include('cruds.fields.visibility_id', ['model' => $preset ?? null])
</x-grid>

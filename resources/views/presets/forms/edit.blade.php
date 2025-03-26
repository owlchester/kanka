@extends('layouts.app', [
    'title' => __('presets.edit.title', ['name' => $preset->name]),
    'centered' => true,
])


@section('content')

    <x-form :action="['preset_types.presets.update', $campaign, $presetType, $preset]" method="PATCH">
        @include('partials.forms._panel', [
            'title' => __('presets.edit.title', ['name' => $preset->name]),
            'content' => 'presets.forms._' . $presetType->code,
            'deleteID' => '#delete-form-preset-' . $preset->id,
        ])
        <input type="hidden" name="from" value="{{ $from }}" />
    </x-form>

@endsection

@section('modals')
    @parent
    <x-form method="DELETE" :action="['preset_types.presets.destroy', $campaign, 'preset_type' => $presetType, 'preset' => $preset]" id="delete-form-preset-{{ $preset->id }}">
    <input type="hidden" name="from" value="{{ $from }}" />
    </x-form>

@endsection

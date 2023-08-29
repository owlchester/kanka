@extends('layouts.app', [
    'title' => __('presets.edit.title', ['name' => $preset->name]),
    'centered' => true,
])


@section('content')

    {!! Form::model($preset, ['route' => ['preset_types.presets.update', $campaign, $presetType, $preset], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}
        @include('partials.forms.form', [
        'title' => __('presets.edit.title', ['name' => $preset->name]),
           'content' => 'presets.forms._' . $presetType->code,
           'deleteID' => '#delete-form-preset-' . $preset->id,
        ])
    <input type="hidden" name="from" value="{{ $from }}" />
    {!! Form::close() !!}

@endsection

@section('modals')
    @parent
    {!! Form::open(['method' => 'DELETE', 'route' => ['preset_types.presets.destroy', $campaign, 'preset_type' => $presetType, 'preset' => $preset], 'id' => 'delete-form-preset-' . $preset->id]) !!}
    <input type="hidden" name="from" value="{{ $from }}" />
    {!! Form::close() !!}

@endsection

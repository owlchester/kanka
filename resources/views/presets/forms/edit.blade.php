@extends('layouts.app', [
    'title' => __('presets.edit.title', ['name' => $preset->name]),
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')

    {!! Form::model($preset, ['route' => ['preset_types.presets.update', 'preset_type' => $presetType, 'preset' => $preset], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}
        <x-box>
            @include('presets.forms._' . $presetType->code)
            <x-box.footer>
                @include('partials.footer_cancel')

                <x-button.delete-confirm target="#delete-form-preset-{{ $preset->id }}" />

                <button type="submit" class="btn2 btn-primary pull-right">
                    {!! __('crud.save') !!}
                </button>
            </x-box.footer>
        </x-box>

        <input type="hidden" name="from" value="{{ $from }}" />

    {!! Form::close() !!}

@endsection

@section('modals')
    @parent
    {!! Form::open(['method' => 'DELETE', 'route' => ['preset_types.presets.destroy', 'preset_type' => $presetType, 'preset' => $preset], 'style' => 'display:inline', 'id' => 'delete-form-preset-' . $preset->id]) !!}
    <input type="hidden" name="from" value="{{ $from }}" />
    {!! Form::close() !!}

@endsection

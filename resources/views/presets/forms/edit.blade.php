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

                <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
                   title="{{ __('crud.delete_modal.title') }}"
                   data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                       <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-form-preset-{{ $preset->id}}'>{{ __('crud.remove') }}</a>">
                    <x-icon class="trash"></x-icon> {{ __('crud.remove') }}
                </a>

                <button type="submit" class="btn btn-success pull-right">
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

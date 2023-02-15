@extends('layouts.app', [
    'title' => __('presets.edit.title', ['name' => $preset->name]),
])



@section('content')

    {!! Form::model($preset, ['route' => ['preset_types.presets.update', $campaign, $presetType, $preset], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}
        <div class="panel">
            @include('presets.forms._' . $presetType->code)
            <div class="panel-footer">
                @include('partials.footer_cancel')

                <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
                   title="{{ __('crud.delete_modal.title') }}"
                   data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                       <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-form-preset-{{ $preset->id}}'>{{ __('crud.remove') }}</a>">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                </a>

                <button type="submit" class="btn btn-success pull-right">
                    {!! __('crud.save') !!}
                </button>
            </div>
        </div>

        <input type="hidden" name="from" value="{{ $from }}" />

    {!! Form::close() !!}

@endsection

@section('modals')
    @parent
    {!! Form::open(['method' => 'DELETE', 'route' => ['preset_types.presets.destroy', ['campaign' => $campaign, 'preset_type' => $presetType, 'preset' => $preset]], 'style' => 'display:inline', 'id' => 'delete-form-preset-' . $preset->id]) !!}
    <input type="hidden" name="from" value="{{ $from }}" />
    {!! Form::close() !!}

@endsection

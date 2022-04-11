@extends('layouts.app', [
    'title' => __('settings.marketplace.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    {!! Form::model(auth()->user(), ['method' => 'POST', 'route' => ['settings.marketplace.save'], 'data-shortcut' => 1]) !!}
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('settings.marketplace.title') }}
            </h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label>{{ __('settings.marketplace.fields.name') }}</label>
                {!! Form::text('marketplace_name', auth()->user()->marketplaceName, ['class' => 'form-control', 'maxlength' => 32]) !!}
                <p class="help-block">{!! __('settings.marketplace.helper', ['marketplace' => link_to(config('marketplace.url'), __('front.menu.marketplace'), ['target' => '_blank'])]) !!}</p>
            </div>
        </div>
        <div class="box-footer text-right">
            <button class="btn btn-primary">
                {{ __('crud.save') }}
            </button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

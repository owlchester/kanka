@extends('layouts.app', [
    'title' => __('settings.marketplace.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@inject('pagination', App\Services\PaginationService)

@section('content')
    @include('partials.errors')
    {!! Form::model(auth()->user(), ['method' => 'POST', 'route' => ['settings.marketplace.save']]) !!}
    <div class="box box-solid">
        <div class="box-body">
            <h2 class="page-header with-border">
                {{ __('settings.marketplace.title') }}
            </h2>

            <div class="form-group">
                <label>{{ __('settings.marketplace.fields.name') }}</label>
                {!! Form::text('marketplace_name', auth()->user()->marketplaceName, ['class' => 'form-control', 'maxlength' => 32]) !!}
                <p class="help-block">{!! __('settings.marketplace.helper', ['marketplace' => link_to(config('marketplace.url'), __('front.menu.marketplace'), ['target' => '_blank'])]) !!}</p>
            </div>

            <button class="btn btn-primary">
                {{ __('crud.save') }}
            </button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@extends('layouts.app', [
    'title' => trans('campaigns.export.title', ['name' => $campaign->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        trans('campaigns.show.tabs.export')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'export'])
        </div>
        <div class="col-md-9">
            {!! Form::open(['method' => 'POST', 'route' => ['campaign_export']]) !!}
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa-solid fa-download"></i> {{ __('campaigns.show.tabs.export') }}
                    </h3>
                </div>
                <div class="box-body">
                    <p>{{ __('campaigns.export.helper') }}</p>
                    <p>{!! __('campaigns.export.helper_secondary', [
    'api' => link_to('/docs/1.0', __('front.menu.api'))
]) !!}</p>
                    <p class="help-text">
                        {{ __('campaigns.export.helper_third') }}
                    </p>

                </div>
                <div class="box-footer text-right">
                    <button class="btn btn-primary">
                        <i class="fa-solid fa-download"></i> {{ __('crud.export') }}
                    </button>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection

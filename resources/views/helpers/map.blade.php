@extends('layouts.app', [
    'title' => __('helpers.title'),
    'breadcrumbs' => [
        __('helpers.map.title')
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4>{{ __('helpers.map.title') }}</h4>
                </div>

                <div class="box-body">
                    <p>
                        {{ __('helpers.map.description') }}
                    </p>
                    <p>
                        {{ __('helpers.map.private') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

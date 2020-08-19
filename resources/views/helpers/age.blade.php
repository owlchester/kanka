@extends('layouts.app', [
    'title' => __('helpers.title'),
    'breadcrumbs' => [
        __('helpers.age.title')
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4>{{ __('helpers.age.title') }}</h4>
                </div>

                <div class="box-body">
                    <p>
                        {{ __('helpers.age.description') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

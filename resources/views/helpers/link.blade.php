@extends('layouts.app', [
    'title' => trans('helpers.title'),
    'description' => trans('helpers.description'),
    'breadcrumbs' => [
        trans('helpers.link.title')
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h4>{{ trans('helpers.link.title') }}</h4>
                </div>

                <div class="box-body">
                    <p>
                        {{ trans('helpers.link.description') }}
                    </p>
                    <p>
                        {!! trans('helpers.link.mentions', [
                            'code' => '<code>@</code>',
                            'example' => '<code>[entity:123]</code>',
                            'example_name' => '<code>[entity:123|Alex]</code>',
                            'example_page' => '<code>[entity:123|page:inventory]</code>',
                            'example_tab' => '<code>[entity:123|tab:relations]</code>',
                        ]) !!}
                    </p>
                    <p>
                        {!! trans('helpers.link.months', [
                            'code' => '<code>#</code>'
                        ]) !!}
                    </p>
                    <p class="info">{{ __('helpers.link.limitations') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

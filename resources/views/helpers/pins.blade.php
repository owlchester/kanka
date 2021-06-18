@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('helpers.pins.title'),
    'breadcrumbs' => [
        __('helpers.pins.title')
    ]
])

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('helpers.pins.title') }}
            </h3>
        </div>

        <div class="box-body">
            <p>
                {{ __('helpers.pins.description') }}
            </p>
        </div>
    </div>
@endsection

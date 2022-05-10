@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('helpers.calendar-widget.title'),
    'breadcrumbs' => [
        __('helpers.calendar-widget.title')
    ]
])

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('helpers.calendar-widget.title') }}
            </h3>
        </div>

        <div class="box-body">
            <p>
                {{ __('helpers.calendar-widget.description') }}
            </p>
        </div>
    </div>
@endsection

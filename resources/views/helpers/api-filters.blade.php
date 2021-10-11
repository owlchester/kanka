@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('helpers.api-filters.title'),
    'breadcrumbs' => false,
])

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('helpers.api-filters.title') }}
            </h3>
        </div>

        <div class="box-body">
            <p>
                {{ __('helpers.api-filters.description', ['name' => $type]) }}
            </p>

            <ul class="">
                @foreach ($filters as $filter)
                    <li>{{ $filter }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

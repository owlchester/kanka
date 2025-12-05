@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('helpers.api-filters.title'),
    'breadcrumbs' => false,
])

@section('content')
    @if (request()->ajax())
    <h3 class="text-xl">
        {{ __('helpers.api-filters.title') }}
    </h3>
    @endif
    <x-box>
        <p>
            {{ __('helpers.api-filters.description', ['name' => $type]) }}
        </p>

        <ul class="">
            @foreach ($filters as $filter)
                <li>{{ $filter }}</li>
            @endforeach
        </ul>
    </x-box>
@endsection

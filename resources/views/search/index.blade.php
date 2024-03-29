@extends('layouts.app', [
    'title' => __('search.title'),
    'breadcrumbs' => [
        __('search.title'),
    ]
])

@section('content')
    {!! Form::open(['route' => ['search', $campaign], 'method' => 'GET']) !!}
        <x-box>
            <div class="input-group">
                <input type="text" name="q" class="" placeholder="Search..." value="{{ request()->get('q') }}">

                <div class="input-group-btn">
                    <button type="submit" class="btn2 btn-primary">
                        <i class="fa-solid fa-search"></i> {{ __('crud.search') }}
                    </button>
                </div>
            </div>
        </x-box>
    {!! Form::close() !!}

    <div class="grid gap-5 grid-cols-1 md:grid-cols-2 mb-4">
        @forelse ($results as $element => $values)
            @if (!empty($values) && count($values) > 0)
                @if ($element == 'characters')
                    <div class="grid-col-2">
                @else
                    <div class="">
                @endif
                    <h3 class="">
                        {{ __('entities.' . $element) }}
                        <span class="badge bg-blue-500">{{ count($values) }}</span>
                    </h3>
                    <x-box>
                        @include($element . '.datagrid', ['models' => $values])
                    </x-box>
                </div>
            @endif
        @empty
        @endforelse
    </div>
@endsection

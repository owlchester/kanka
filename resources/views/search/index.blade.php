@extends('layouts.app', [
    'title' => __('search.title'),
    'breadcrumbs' => [
        __('search.title'),
    ]
])
@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    {!! Form::open(['route' => 'search', 'method' => 'GET']) !!}

            <x-box>
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search..." value="{{ request()->get('q') }}">

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-search"></i> {{ __('crud.search') }}
                        </button>
                    </div>
                </div>
            </x-box>
    {!! Form::close() !!}

    <div class="row">
        @forelse ($results as $element => $values)
            @if (!empty($values) && count($values) > 0)
                @if ($element == 'characters')
                    <div class="col-md-12">
                @else
                    <div class="col-md-6">
                @endif
                    <h3 class="">
                        {{ __('entities.' . $element) }}
                        <span class="badge bg-blue">{{ count($values) }}</span>
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

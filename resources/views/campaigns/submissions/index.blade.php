@php
    use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => trans('campaigns/submissions.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        __('campaigns.show.tabs.applications')
    ],
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'submissions'])
        </div>
        <div class="col-md-9">
            @if(!$campaign->is_open)
                <p class="alert alert-warning">
                    {{ __('campaigns/submissions.errors.not_open') }}
                </p>
            @else
                @if(!$campaign->isPublic())
                    <p class="alert alert-warning">
                        {{ __('campaigns/submissions.errors.open_not_public') }}
                    </p>
                @else
                    <p class="alert alert-info">
                        {{ __('campaigns/submissions.helpers.open_and_public', [
    'tab' => __('campaigns.panels.sharing')
]) }}
                    </p>
                    @include('campaigns.submissions._list')
                @endif
            @endif
        </div>
    </div>
@endsection

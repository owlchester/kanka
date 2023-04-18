@extends('layouts.app', [
    'title' => trans('campaigns.roles.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        trans('campaigns.show.tabs.roles')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    <div class="flex gap-2 flex-col lg:flex-row lg:gap-5">
        <div class="lg:flex-none lg:w-60">
            @include('campaigns._menu', ['active' => 'roles'])
        </div>
        <div class="grow">
            @include('campaigns.roles.index')
        </div>
    </div>
@endsection

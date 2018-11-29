<?php /** @var \App\Models\Campaign $campaign */ ?>

@extends('layouts.app', [
    'title' => trans('dashboard.title'),
    'description' => trans('dashboard.description'),
    'breadcrumbs' => false,
    'headerExtra' => $settings ? '<a href="' . route('dashboard.settings') .'" class="btn btn-default btn-xl" title="'. trans('dashboard.settings.title') .'"><i class="fa fa-cog"></i></a>' : null
])

@section('content')

    @include('partials.errors')

    <div class="campaign @if(!empty($campaign->header_image))" style="background-image: url({{ Storage::url($campaign->header_image) }}) @else no-header @endif ">
        <div class="content">
            @if (!empty($campaign->image))
                <a class="image" href="{{ Storage::url($campaign->image) }}" title="{{ $campaign->name }}" target="_blank">
                    <img class="img-circle" src="{{ Storage::url($campaign->image) }}" alt="{{ $campaign->name }} picture">
                </a>
            @endif
            <div class="title">
                <h1>
                    <a href="{{ route('campaigns.show', $campaign) }}">{{ $campaign->name }}</a>
                </h1>
            </div>
            @if (!empty(strip_tags($campaign->entry)))
                <div class="preview">
                    {!! $campaign->entry !!}
                </div>
                <div class="more">
                    <a href="{{ route('campaigns.show', $campaign) }}">{{ __('crud.actions.find_out_more') }}</a>
                </div>
            @endif

            @can('update', $campaign)
            <ul class="campaign-links">
                <li>
                    <a href="{{ route('campaign_users.index') }}">
                        <i class="fa fa-users"></i>
                        {{ __('dashboard.campaigns.tabs.users', ['count' => $campaign->users()->count()]) }}
                    </a>
                </li>
                <li class="@if(!empty($active) && $active == 'roles')active @endif">
                    <a href="{{ route('campaign_roles.index') }}">
                        <i class="fa fa-layer-group"></i>
                        {{ __('dashboard.campaigns.tabs.roles', ['count' => $campaign->roles()->count()]) }}
                    </a>
                </li>
                <li class="@if(!empty($active) && $active == 'settings')active @endif">
                    <a href="{{ route('campaign_settings') }}">
                        <i class="fa fa-cogs"></i>
                        {{ __('dashboard.campaigns.tabs.modules', ['count' => $campaign->setting->countEnabledModules()]) }}
                    </a>
                </li>
            </ul>
            @endcan
        </div>
    </div>

    <div class="row">
        @if ($settings && $settings->has('release') && !empty($release))
        <div class="col-md-4 col-md-offset-4">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-lightbulb-o"></i></span>
                <div class="info-box-content">
                    <div class="info-box-text">{{ trans('dashboard.latest_release' )}}</div>
                    <div class="info-box-number">
                        <a href="{{ route('releases.show', $release->getSlug()) }}">
                            {{ $release->title }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @if (!empty($notes))
        <div class="row">
            @foreach ($notes as $note)
                <div class="col-md-{{ (12 / (count($notes))) }}">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4><a href="{{ route('notes.show', $note->id) }}">{{ $note->name }}</a></h4>
                            <div class="pinned-entity preview" data-toggle="preview">
                            {!! $note->entry !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <?php $cpt = 0; ?>
    <div class="row">
        @if ($campaign->enabled('characters') && (!$settings || $settings->has('characters')))
            @if ($cpt == 3) </div><div class="row"> @endif
            @include('dashboard._recent', ['title' => trans('entities.characters'), 'route' => 'characters', 'models' => $characters, 'perm' => 'App\Models\Character'])
            <?php $cpt++; ?>
        @endif
        @if ($campaign->enabled('families') && (!$settings || $settings->has('families')))
            @if ($cpt == 3) </div><div class="row"> @endif
            @include('dashboard._recent', ['title' => trans('entities.families'), 'route' => 'families', 'models' => $families, 'perm' => 'App\Models\Family'])
        <?php $cpt++; ?>
        @endif
        @if ($campaign->enabled('locations') && (!$settings || $settings->has('locations')))
            @if ($cpt == 3) </div><div class="row"> @endif
            @include('dashboard._recent', ['title' => trans('entities.locations'), 'route' => 'locations', 'models' => $locations, 'perm' => 'App\Models\Location'])
        <?php $cpt++; ?>
        @endif
        @if ($campaign->enabled('organisations') && (!$settings || $settings->has('organisations')))
            @if ($cpt == 3) </div><div class="row"> @endif
            @include('dashboard._recent', ['title' => trans('entities.organisations'), 'route' => 'organisations', 'models' => $organisations, 'perm' => 'App\Models\Organisation'])
        <?php $cpt++; ?>
        @endif
        @if ($campaign->enabled('items') && (!$settings || $settings->has('items')))
            @if ($cpt == 3) </div><div class="row"> @endif
            @include('dashboard._recent', ['title' => trans('entities.items'), 'route' => 'items', 'models' => $items, 'perm' => 'App\Models\Item'])
        <?php $cpt++; ?>
        @endif
        @if ($campaign->enabled('journals') && (!$settings || $settings->has('journals')))
            @if ($cpt == 3) </div><div class="row"> @endif
            @include('dashboard._recent', ['title' => trans('entities.journals'), 'route' => 'journals', 'models' => $journals, 'perm' => 'App\Models\Journal'])
        <?php $cpt++; ?>
        @endif
    </div>
@endsection


@section('scripts')
    <script src="{{ mix('js/dashboard.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
@endsection
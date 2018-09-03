@extends('layouts.app', [
    'title' => trans('dashboard.title'),
    'description' => trans('dashboard.description'),
    'headerExtra' => $settings ? '<a href="' . route('dashboard.settings') .'" class="btn btn-default btn-xl" title="'. trans('dashboard.settings.title') .'"><i class="fa fa-cog"></i></a>' : null
])

@section('content')

    @include('partials.errors')

    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 class="campaign-name">{{ $campaign->name }}</h3>
                </div>
                @if (Auth::check())
                <a class="small-box-footer" href="{{ route('campaigns.index') }}">
                    <i class="fa fa-arrow-circle-right"></i> {{ trans('dashboard.campaigns.manage') }}
                </a>
                @endif
            </div>
        </div>
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
                        <div class="panel-heading">
                            <h4><a href="{{ route('notes.show', $note->id) }}">{{ $note->name }}</a></h4>
                        </div>
                        <div class="panel-body">
                            {!! $note->entry !!}
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

<?php /** @var \App\Models\Campaign $campaign */ ?>
<?php $position = 0; ?>

@extends('layouts.app', [
    'title' => trans('dashboard.title'),
    'description' => trans('dashboard.description'),
    'breadcrumbs' => false,
    'headerExtra' => $settings ? '<a href="' . route('dashboard.setup') .'" class="btn btn-default btn-xl pull-right" title="'. trans('dashboard.settings.title') .'"><i class="fa fa-cog"></i></a>' : null
])

@section('content')

    @include('partials.errors')

    @if (!empty($release) && (!auth()->check() || auth()->user()->release != $release->id))
        <div class="alert alert-info alert-dismissible">
            @auth
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" data-url="{{ route('settings.release', $release) }}">×</button>
            @endauth
            <h4><i class="icon fa fa-info"></i> <a href="{{ route('releases.show', $release->getSlug()) }}">{{ $release->title }}</a></h4>
            {{ $release->excerpt }}
        </div>
    @endif

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
    @foreach ($widgets as $widget)
        <?php if ($widget->widget != \App\Models\CampaignDashboardWidget::WIDGET_RECENT && (empty($widget->entity) || empty($widget->entity->child))):
            continue;
        endif; ?>
        @if ($position + $widget->colSize() > 12)
            </div><div class="row">
        <?php $position = 0; ?>
        @endif
            <div class="col-md-{{ $widget->colSize() }}">
                <div class="widget widget-{{ $widget->widget }}">
                    @include('dashboard.widgets._' . $widget->widget)
                </div>
            </div>

        <?php $position += $widget->colSize(); ?>
    @endforeach
    </div>

    @if (count($widgets) == 0)
    <div class="row">
        <div class="col-md-12 text-center">
            <a href="{{ route('dashboard.setup') }}">
                <h3>{{ __('dashboard.helpers.setup') }}</h3>
            </a>
        </div>
    </div>
    @endif
@endsection


@section('scripts')
    <script src="{{ mix('js/dashboard.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
@endsection
<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Release $release
 */ ?>
<?php $position = 0; ?>

@extends('layouts.app', [
    'title' => __('dashboard.title') . ' ' . $campaign->name,
    'breadcrumbs' => false,
    'canonical' => true,
    'contentId' => 'campaign-dashboard',
])

@section('og')
    <meta property="og:description" content="{{ $campaign->excerpt ?: $campaign->tooltip() }}" />
    @if ($campaign->image)<meta property="og:image" content="{{ Img::crop(50, 50)->url($campaign->image)  }}" />@endif
    <meta property="og:url" content="{{ route('campaigns.show', $campaign)  }}" />
@endsection

@section('header-extra')
    <div class="dashboard-actions">
        @if($settings)
            <a href="{{ route('dashboard.setup') }}" class="btn btn-default btn-xl" title="{{ __('dashboard.settings.title') }}">
                <i class="fa fa-cog"></i>
            </a>
        @endif
        @can ('follow', $campaign)
            <button id="campaign-follow" class="btn btn-default btn-xl" data-id="{{ $campaign->id }}"
                    style="display: none"
                    data-following="{{ $campaign->isFollowing() ? true : false }}"
                    data-follow="{{ __('dashboard.actions.follow') }}"
                    data-unfollow="{{ __('dashboard.actions.unfollow') }}"
                    data-url="{{ route('campaign.follow') }}"
                    data-toggle="tooltip" title="{{ __('dashboard.helpers.follow') }}"
                    data-placement="bottom"
            >
                <i class="fa fa-star"></i> <span id="campaign-follow-text"></span>
            </button>
        @endcan
    </div>
@endsection


@section('content')

    @include('partials.errors')

    <div class="campaign @if(!empty($campaign->header_image))cover-background" style="background-image: url({{ Img::crop(1200, 400)->url($campaign->header_image) }}) @else no-header @endif ">
        <div class="content">
            <div class="title">
                <h1>
                    @if (!empty($campaign->image))
                        <img class="img-circle cover-background" src="{{ Img::crop(50, 50)->url($campaign->image) }}" alt="{{ $campaign->name }} picture">
                    @endif
                    <a href="{{ route('campaigns.show', $campaign) }}" title="{!! $campaign->name !!}">{!! $campaign->name !!}</a>
                </h1>
            </div>
            @if ($campaign->hasPreview())
                <div class="preview">
                    {!! $campaign->preview() !!}
                </div>
                <div class="more">
                    <a href="{{ route('campaigns.show', $campaign) }}">{{ __('crud.actions.find_out_more') }}</a>
                </div>
            @endif

            @can('update', $campaign)
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-2">
                    <a href="{{ route('campaign_users.index') }}" class="campaign-link" title="{{ __('dashboard.campaigns.tabs.users', ['count' => \App\Facades\CampaignCache::members()->count()]) }}">
                        <i class="fa fa-user"></i> {{ \App\Facades\CampaignCache::members()->count() }}
                    </a>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-2">
                    <a href="{{ route('campaign_roles.index') }}" class="campaign-link" title="{{  __('dashboard.campaigns.tabs.roles', ['count' => \App\Facades\CampaignCache::roles()->count()]) }}">
                        <i class="fa fa-lock"></i> {{ \App\Facades\CampaignCache::roles()->count() }}
                    </a>
                </div>
                <div class="col-md-2 hidden-xs hidden-sm">
                    <a href="{{ route('campaign_settings') }}" class="campaign-link" title="{{ __('dashboard.campaigns.tabs.modules', ['count' => $campaign->setting->countEnabledModules()]) }}">
                        <i class="fa fa-cogs"></i> {{ $campaign->setting->countEnabledModules() }}
                    </a>
                </div>
            </div>
            @endcan
        </div>
    </div>

    <div class="row">
    @foreach ($widgets as $widget)
        <?php if ($widget->widget != \App\Models\CampaignDashboardWidget::WIDGET_RECENT && (empty($widget->entity) || !EntityPermission::canView($widget->entity))):
            continue;
        elseif ($widget->widget == \App\Models\CampaignDashboardWidget::WIDGET_PREVIEW && !EntityPermission::canView($widget->entity)):
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

    @if ($settings)
        <div class="row margin-top">
            <div class="col-md-12 text-center">
                <a href="{{ route('dashboard.setup') }}" class="btn btn-default btn-lg" title="{{ trans('dashboard.settings.title') }}">
                    <i class="fa fa-cog"></i> {{ trans('dashboard.settings.title') }}
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

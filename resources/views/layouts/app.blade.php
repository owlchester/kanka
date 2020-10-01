<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\MiscModel $miscModel
 */
$campaign = CampaignLocalization::getCampaign(); ?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() == 'he') dir="rtl" @endif>
<head>
@include('layouts._tracking')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{!! $title ?? '' !!} - {{ config('app.name', 'Kanka') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta property="og:title" content="{{ $title ?? '' }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />
@if (isset($canonical))
    <link rel="canonical" href="{{ LaravelLocalization::localizeURL(null, $campaign->locale) }}" />
@endif
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <link rel="alternate" href="{{ LaravelLocalization::localizeUrl(null, $localeCode) }}" hreflang="{{ $localeCode }}">
@endforeach

    @yield('og')
    <link rel="icon" type="image/png" href="/favicon.ico?v=3">

    <!-- Styles -->
    <link href="{{ mix('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/freyja.css') }}" rel="stylesheet">
@if(app()->getLocale() == 'he')
    <link href="{{ mix('css/app-rtl.css') }}" rel="stylesheet">
@endif
@yield('styles')

@if (request()->has('_theme') && in_array(request()->get('_theme'), ['dark', 'midnight', 'future', 'base']))
    @if(request()->get('_theme') != 'base')
    <link href="{{ mix('css/' . request()->get('_theme') . '.css') }}" rel="stylesheet">
    @endif
@else
    @if (!empty($campaign) && $campaign->boosted() && !empty($campaign->theme))
    @if ($campaign->theme_id !== 1)
        <link href="{{ mix('css/' . $campaign->theme->name . '.css') }}" rel="stylesheet">
    @endif
    @elseif (auth()->check() && !empty(auth()->user()->theme))
        <link href="{{ mix('css/' . auth()->user()->theme . '.css') }}" rel="stylesheet">
    @endif
@endif

@if(!empty($campaign) && $campaign->boosted() && $campaign->hasPluginTheme())
    <link href="{{ route('campaign_plugins.css', ['ts' => $campaign->updated_at->getTimestamp()]) }}" rel="stylesheet">
@endif
@if (!empty($campaign) && $campaign->boosted() && !empty($campaign->css))
    <link href="{{ route('campaign.css', ['ts' => $campaign->updated_at->getTimestamp()]) }}" rel="stylesheet">
@endif
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
</head>
{{-- Hide the sidebar if the there is no current campaign --}}
<body class="skin-black sidebar-mini @if (!empty($campaign) || (auth()->check() && auth()->user()->hasCampaigns()) || (!empty($sidebar) && $sidebar == 'settings')) @else layout-top-nav @endif @if(isset($miscModel) && !empty($miscModel->entity)) kanka-entity-{{ $miscModel->entity->id }} kanka-entity-{{ $miscModel->getEntityType() }} @if(!empty($miscModel->type)) kanka-type-{{ \Illuminate\Support\Str::slug($miscModel->type) }}@endif @endif">
@include('layouts._tracking-fallback')
    <div id="app" class="wrapper">
        <!-- Header -->
        @include('layouts.header')

        <!-- Sidebar -->
        @include('layouts.sidebars.' . ($sidebar ?? 'app'))

        @yield('fullpage-form')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" @if(isset($contentId)) id="{{ $contentId }}" @endif>
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @if (!isset($breadcrumbs) || $breadcrumbs !== false)
                <ol class="breadcrumb">
                    @if ($campaign)
                        <li><a href="{{ route('dashboard') }}"><i class="fa fa-globe"></i> {!! $campaign->name !!}</a></li>
                    @else
                        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.title') }}</a></li>
                    @endif
                    @if (isset($breadcrumbs))
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li>
                                @if (!empty($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}" title="{{ $breadcrumb['label'] }}">
                                        @if (strlen($breadcrumb['label']) > 22)
                                            {{ substr($breadcrumb['label'], 0, 20) . '...' }}
                                        @else
                                            {{ $breadcrumb['label'] }}
                                        @endif
                                    </a>
                                @else
                                    @if (strlen($breadcrumb) > 22)
                                        <span title="{{ $breadcrumb }}">{{ substr($breadcrumb, 0, 20) . '...' }}</span>
                                    @else
                                        {{ $breadcrumb }}
                                    @endif
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ol>
                @endif

                @if (!View::hasSection('entity-header'))
                    @if (isset($mainTitle))
                        @yield('header-extra')
                    @else
                        <h1>
                            @yield('header-extra')
                            {!! $title ?? "Page Title" !!}
                            <small class="hidden-xs hidden-sm">{{ $description ?? null }}</small>
                        </h1>
                    @endif
                @endif
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @if (auth()->check() && \App\Facades\Identity::isImpersonating())
                    <div class="alert alert-warning">
                        <h4>
                            <i class="icon fa fa-exclamation-triangle"></i>
                            {{ __('campaigns.members.impersonating.title', ['name' => auth()->user()->name]) }}
                        </h4>
                        <p>{{ __('campaigns.members.impersonating.message') }}</p>
                    </div>
                @endif
                @include('partials.success')

@if(auth()->guest() && !empty(config('tracking.adsense')))
                <!-- Side -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-1686281547359435"
                     data-ad-slot="2711573107"
                     data-ad-format="auto"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <p class="text-center text-muted">{!! __('misc.ads.remove', ['login' => link_to_route('login', __('misc.ads.login'))]) !!}</p>
@endif

                @yield('entity-actions')
                @yield('entity-header')
                @yield('content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        @yield('fullpage-form-end')

        <!-- Footer -->
        @include('layouts.footer')

    </div>

    <!-- Modal -->
    <div class="modal fade" id="delete-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('crud.delete_modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p id="delete-confirm-text">
                        {!! trans('crud.delete_modal.description', ['tag' => '<b><span id="delete-confirm-name"></span></b>']) !!}
                    </p>
                    <div id="delete-confirm-mirror" class="form-group" style="display: none">
                        <label>
                            <input type="checkbox" id="delete-confirm-mirror-chexkbox" name="delete-mirror">
                            {{ __('crud.delete_modal.mirrored') }}
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="delete-confirm-submit"><span class="fa fa-trash"></span> {{ trans('crud.delete_modal.delete') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="click-confirm" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="clickModalLabel">{{ trans('crud.click_modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p id="click-confirm-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.delete_modal.close') }}</button>
                    <a href="" type="button" class="btn btn-danger" id="click-confirm-url">{{ trans('crud.click_modal.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- new foreign model -->
    <div class="modal fade" id="new-entity-modal" tabindex="-1" role="dialog" aria-labelledby="newEntityModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="newEntityModalLabel">{{ trans('crud.new_entity.title') }}</h4>
                </div>
                {!! Form::open(['url' => route('entities.create'), 'method' => 'POST', 'id' => 'new-entity-form']) !!}
                <div class="modal-body">
                    <div class="form-group required">
                        <label>{{ trans('crud.new_entity.fields.name') }}</label>
                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'new-entity-name']) !!}
                    </div>
                    <p class="text-red" id="new-entity-errors" style="display:none">{{ trans('crud.new_entity.error') }}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="new-entity-save" data-text="{{ trans('crud.save') }}">{{ trans('crud.save') }}</button>
                </div>
                {{ csrf_field() }}
                {!! Form::hidden('target', null, ['id' => 'new-entity-type']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <!-- Standard Sized Modal -->
    <div class="modal fade" id="entity-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content"></div>
        </div>
    </div>

    <!-- Large Sized Modal -->
    <div class="modal fade" id="large-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="large-modal-content"></div>
        </div>
    </div>

    @yield('modals')

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/d7f0be4a8d.js" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="/js/select2/i18n/{{ LaravelLocalization::getCurrentLocale() == 'en-US' ? 'en' : LaravelLocalization::getCurrentLocale() }}.js" defer></script>
    @yield('scripts')
</body>
</html>

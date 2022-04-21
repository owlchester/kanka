<?php /** @var \App\Models\CampaignStyle $style */
use App\Facades\Datagrid ?>
@extends('layouts.app', [
    'title' => __('campaigns/styles.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        __('campaigns.show.tabs.styles')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'styles'])
        </div>
        <div class="col-md-9">
            @if (!$campaign->boosted())
                <div class="box box-solid">
                    <div class="box-body">
                        <p class="help-block">
                            {!! __('campaigns/styles.helpers.main', ['here' => link_to('https://blog.kanka.io/category/tutorials', __('campaigns/styles.helpers.here'), ['target' => '_blank'])]) !!}
                        </p>

                        @include('partials.boosted', ['callout' => true])
                    </div>
                </div>
            @else

            @php \App\Facades\Datagrid::layout(\App\Renderers\Layouts\Campaign\Theme::class)->permissions(false) @endphp
            @if(Datagrid::hasBulks()) {!! Form::open(['route' => 'campaign_styles.bulk']) !!} @endif
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('campaigns.show.tabs.styles') }}</h3>
                    <div class="box-tools">
                        <button class="btn btn-default btn-sm" data-toggle="modal"
                                data-target="#theming-help">
                            <i class="fas fa-question-circle" aria-hidden="true"></i>
                            {{ __('campaigns.members.actions.help') }}
                        </button>

                        <a href="#" data-url="{{ route('campaign-theme') }}" data-target="#entity-modal" data-toggle="ajax-modal" class="btn btn-default btn-sm" >
                            <i class="fas fa-brush"></i> {{ __('campaigns/styles.actions.current', ['theme' => !empty($theme) ? $theme->__toString() : __('crud.filters.options.none')]) }}
                        </a>

                        <a href="{{ route('campaign_styles.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> {{ __('campaigns/styles.actions.new') }}
                        </a>
                    </div>
                </div>
                @if ($styles->count() === 0)
                    <div class="box-body">
                        <p class="help-block">
                            {!! __('campaigns/styles.helpers.main', ['here' => link_to('https://blog.kanka.io/category/tutorials', __('campaigns/styles.helpers.here'), ['target' => '_blank'])]) !!}
                        </p>
                    </div>
                @else
                    <div class="box-body no-padding">
                        <table class="table table-hover">
                        <thead>
                            <tr>
                            @foreach (Datagrid::headers() as $header)
                                @include('layouts.datagrid._header')
                            @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($styles as $style)
                            <tr>
                            @foreach (Datagrid::columns($style) as $column)
                                @include('layouts.datagrid._column')
                            @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    @if (Datagrid::hasBulks())
                    <div class="box-footer text-right">
                        <div class="pull-left">
                            @includeWhen(Datagrid::hasBulks(), 'layouts.datagrid.bulks')
                        </div>
                    </div>
                    @endif
                @endif
            </div>
            @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif

                @include('campaigns.styles._reorder')
            @endif
        </div>
    </div>
@endsection


@section('modals')

    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])

    <div class="modal fade" id="theming-help" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ __('campaigns.show.tabs.styles') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        {!! __('campaigns/styles.helpers.main', ['here' => link_to('https://blog.kanka.io/category/tutorials', __('campaigns/styles.helpers.here'), ['target' => '_blank'])]) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('styles')
    @parent
    <link href="{{ mix('css/story.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/story.js') }}" defer></script>
@endsection

<?php /** @var \App\Models\CampaignStyle $style */?>
@extends('layouts.app', [
    'title' => __('campaigns/sidebar.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        __('campaigns.show.tabs.sidebar')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'sidebar'])
        </div>
        <div class="col-md-9">
            <h3 class="mt-0 inline-block">
                {{ __('campaigns.show.tabs.sidebar') }}
            </h3>

            @if (!$campaign->boosted())
                @include('layouts.callouts.boost', ['texts' => [__('campaigns/sidebar.call-to-action')]])
            @else
                <button class="btn btn-sm btn-default pull-right" data-toggle="dialog"
                        data-target="sidebar-help">
                    <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                    {{ __('campaigns.members.actions.help') }}
                </button>
            {!! Form::open([
    'route' => 'campaign-sidebar-save',
    'method' => 'POST',
    'class' => 'sidebar-setup form-inline form-mobile-inline',
    'data-shortcut' => 1
]) !!}
            <div class="box box-solid">
                <div class="box-body">
                    <p class="alert alert-warning hidden-md hidden-lg">
                        {{ __('campaigns/sidebar.helpers.mobile_reordering') }}
                    </p>


                    <ul class="sidebar-sortable nested-sortable">
                    @foreach ($layout as $name => $setup)
                        <li class="@if (isset($setup['fixed'])) fixed @endif" id="{{ $name }}">
                            <i class="{{ $setup['custom_icon'] ?: $setup['icon'] }}"></i>
                            <span class="text-muted text-sm hidden-md hidden-lg">({{ $setup['label'] }})</span>
                            <br class="hidden-md hidden-lg" />
                            <input type="text" class="form-control" name="{{ $name }}_icon" value="{{ $setup['custom_icon'] }}" placeholder="{{$setup['icon'] }}" maxlength="50" />
                            <input type="text" class="form-control" name="{{ $name }}_label" value="{{ $setup['custom_label'] }}" placeholder="{{$setup['label'] }}" maxlength="90" />
                            <span class="text-muted text-sm hidden-xs hidden-sm">({{ $setup['label'] }})</span>
                            <input type="hidden" name="order[{{ $name }}]" value="1" />
                            @if (empty($setup['children']))
                                @continue
                            @endif
                            <input type="hidden" name="order[{{ $name }}_start]" value="1" />
                            {!! Form::hidden('section_' . $name . '_start', 1) !!}
                            <ul class="sidebar-sortable nested-sortable">
                                @foreach ($setup['children'] as $childName => $child)
                                    <li id="{{ $childName }}">
                                        <i class="{{ $child['custom_icon'] ?: $child['icon'] }}"></i>
                                        <span class="text-muted text-sm hidden-md hidden-lg">({{ $child['label'] }})</span>
                                        <br class="hidden-md hidden-lg" />
                                        <input type="text" class="form-control" name="{{ $childName }}_icon" value="{{ $child['custom_icon'] }}" placeholder="{{ $child['icon'] }}" maxlength="50" />
                                        <input type="text" class="form-control" name="{{ $childName }}_label" value="{{ $child['custom_label'] }}" placeholder="{{ $child['label'] }}" maxlength="90" />
                                        <span class="text-muted text-sm hidden-xs hidden-sm">({{ $child['label'] }})</span>
                                        <input type="hidden" name="order[{{ $childName }}]" value="1" />
                                    </li>
                                @endforeach
                            </ul>
                            <input type="hidden" name="order[{{ $name }}_end]" value="1" />
                            {!! Form::hidden('section_' . $name . '_end', 1) !!}
                        </li>
                    @endforeach
                    </ul>
                </div>
                <div class="box-footer text-right">
                    <a href="#" class="btn btn-default pull-left" data-toggle="modal" data-target="#reset-confirm">
                        <i class="fa-solid fa-trash"></i> {{ __('campaigns/sidebar.actions.reset') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i>
                        {{ __('crud.save') }}
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
            @endif
        </div>
    </div>

@endsection

@section('modals')

    {!! Form::open([
        'method' => 'DELETE',
        'route' => [
            'campaign-sidebar-reset',
        ]
    ]) !!}
    <div class="modal fade" id="reset-confirm" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="clickModalLabel">{{ __('campaigns/sidebar.reset.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ __('campaigns/sidebar.reset.warning') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.delete_modal.close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('crud.click_modal.confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


    @include('partials.helper-modal', [
        'id' => 'sidebar-help',
        'title' => __('campaigns.show.tabs.sidebar'),
        'textes' => [
            __('campaigns/sidebar.helpers.setup', ['reset' => '<strong>' . __('campaigns/sidebar.actions.reset') . '</strong>']),
            __('campaigns/sidebar.helpers.icons', [
                'link' => link_to('https://fontawesome.com/search?m=free&s=solid', 'FontAwesome', ['target' => '_blank'])
            ])
    ]])
@endsection

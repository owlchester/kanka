<?php /** @var \App\Models\CampaignStyle $style */?>
@extends('layouts.app', [
    'title' => __('campaigns/sidebar.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.sidebar')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="flex gap-2 flex-col lg:flex-row lg:gap-5">
        <div class="lg:flex-none lg:w-60">
            @include('campaigns._menu', ['active' => 'sidebar'])
        </div>
        <div class="grow">

            <div class="flex gap-2 mb-5 items-center">
                <h3 class="m-0 inline-block grow">
                    {{ __('campaigns.show.tabs.sidebar') }}
                </h3>

                @if ($campaign->boosted())
                    <button class="btn btn-sm btn-default pull-right" data-toggle="dialog"
                            data-target="sidebar-help">
                        <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                        {{ __('campaigns.members.actions.help') }}
                    </button>
              @endif
            </div>

            @if (!$campaign->boosted())
                @include('layouts.callouts.boost', ['texts' => [__('campaigns/sidebar.call-to-action')]])
            @else

                <x-tutorial code="sidebar_reorder">
                    <p>
                        {{ __('campaigns/sidebar.helpers.reordering') }}
                    </p>
                </x-tutorial>
                {!! Form::open([
                    'route' => 'campaign-sidebar-save',
                    'method' => 'POST',
                    'class' => 'sidebar-setup form-inline form-mobile-inline',
                    'data-shortcut' => 1
                ]) !!}
            <div class="box box-solid">
                <div class="box-body">
                    <ul class="list-none m-0 p-0 sidebar-sortable nested-sortable">
                    @foreach ($layout as $name => $setup)
                        <li class="p-1 @if (isset($setup['fixed'])) fixed-position @endif" id="{{ $name }}">
                            <p class="text-muted text-sm hidden-md hidden-lg">({{ $setup['label'] }})</p>
                            <div class="input-group">
                                <span class="input-group-addon dnd-handle cursor-move">
                                    <i class="inline-block w-6 {{ $setup['custom_icon'] ?: $setup['icon'] }}" aria-hidden="true"></i>
                                </span>
                                <input type="text" class="form-control" name="{{ $name }}_icon" value="{{ $setup['custom_icon'] }}" placeholder="{{$setup['icon'] }}" maxlength="50" data-paste="fontawesome" />
                            </div>

                            <input type="text" class="form-control" name="{{ $name }}_label" value="{{ $setup['custom_label'] }}" placeholder="{{$setup['label'] }}" maxlength="90" />
                            <span class="text-muted text-sm hidden-xs hidden-sm">({{ $setup['label'] }})</span>
                            <input type="hidden" name="order[{{ $name }}]" value="1" />

                            @if (empty($setup['children']))
                                @continue
                            @endif
                            <input type="hidden" name="order[{{ $name }}_start]" value="1" />
                            {!! Form::hidden('section_' . $name . '_start', 1) !!}
                            <ul class="list-none mt-2 m-0 p-0 pl-4 sidebar-sortable nested-sortable">
                                @foreach ($setup['children'] as $childName => $child)
                                    <li class="p-1 @if (\Illuminate\Support\Arr::get($child, 'disabled') === true) alert-warning @endif" id="{{ $childName }}">
                                        <p class="text-muted text-sm hidden-md hidden-lg">({{ $child['label'] }})</p>
                                        <div class="input-group">
                                            <span class="input-group-addon dnd-handle cursor-move">
                                                <i class="inline-block w-6 {{ $child['custom_icon'] ?: $child['icon'] }}" aria-hidden="true"></i>
                                            </span>
                                            <input type="text" class="form-control" name="{{ $childName }}_icon" value="{{ $child['custom_icon'] }}" placeholder="{{ $child['icon'] }}" data-paste="fontawesome" maxlength="50" />
                                        </div>

                                        <input type="text" class="form-control" name="{{ $childName }}_label" value="{{ $child['custom_label'] }}" placeholder="{{ $child['label'] }}" maxlength="90" />
                                        <span class="text-muted text-sm hidden-xs hidden-sm">(
                                            {{ $child['label'] }}
                                            @if (\Illuminate\Support\Arr::get($child, 'disabled') === true)
                                                <i class="fa-solid fa-exclamation-triangle" aria-hidden="true" data-toggle="tooltip" title="{{ __('campaigns.modules.permission-disabled') }}"></i>
                                            @endif
                                            )
                                        </span>
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
                    <a href="#" class="btn btn-default pull-left" data-toggle="dialog" data-target="reset-confirm">
                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                        {{ __('campaigns/sidebar.actions.reset') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save" aria-hidden="true"></i>
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

    <x-dialog id="reset-confirm" :title="__('campaigns/sidebar.reset.title')">
        <p>{{ __('campaigns/sidebar.reset.warning') }}</p>

        <div class="grid grid-cols-2 gap-2 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>

            {!! Form::open([
                'method' => 'DELETE',
                'route' => [
                    'campaign-sidebar-reset',
                ]
            ]) !!}
                <x-buttons.confirm type="danger" full="true" outline="true">
                    {{ __('crud.click_modal.confirm') }}
                </x-buttons.confirm>
            {!! Form::close() !!}
        </div>
    </x-dialog>


    @include('partials.helper-modal', [
        'id' => 'sidebar-help',
        'title' => __('campaigns.show.tabs.sidebar'),
        'textes' => [
            __('campaigns/sidebar.helpers.setup', ['reset' => '<strong>' . __('campaigns/sidebar.actions.reset') . '</strong>']),
            __('campaigns/sidebar.helpers.icons', [
                'link' => link_to(config('fontawesome.search'), 'FontAwesome', ['target' => '_blank'])
            ])
    ]])
@endsection

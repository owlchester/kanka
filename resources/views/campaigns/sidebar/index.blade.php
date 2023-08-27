<?php /** @var \App\Models\CampaignStyle $style */?>
@extends('layouts.app', [
    'title' => __('campaigns/sidebar.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.sidebar')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')

    <div class="flex gap-5 flex-col max-w-7xl">
        @include('partials.errors')

        <div class="flex gap-2 items-center">
            <h3 class="m-0 inline-block grow">
                {{ __('campaigns.show.tabs.sidebar') }}
            </h3>

            @if ($campaign->boosted())
                <a class="btn2 btn-sm btn-ghost" href="https://docs.kanka.io/en/latest/features/campaigns/sidebar.html" target="_blank">
                    <x-icon class="question"></x-icon>
                    {{ __('crud.actions.help') }}
                </a>
          @endif
        </div>

        @if (!$campaign->boosted())
            <x-cta :campaign="$campaign">
                <p>{{ __('campaigns/sidebar.call-to-action') }}</p>
            </x-cta>
        @else

            <x-tutorial code="sidebar_reorder">
                <p>
                    {{ __('campaigns/sidebar.helpers.reordering') }}
                </p>
            </x-tutorial>
            {!! Form::open([
                'route' => ['campaign-sidebar-save', $campaign],
                'method' => 'POST',
                'class' => 'sidebar-setup form-inline form-mobile-inline',
                'data-shortcut' => 1
            ]) !!}
        <x-box>


            <ul class="list-none m-0 mb-5 p-0 sidebar-sortable nested-sortable">
            @foreach ($layout as $name => $setup)
                <li class="flex md:items-center flex-wrap mb-2 @if (isset($setup['fixed'])) fixed-position @endif" id="{{ $name }}">
                    <p class="text-muted text-sm basis-full mb-0 visible md:hidden">({{ $setup['label'] ?? __($setup['label_key']) }})</p>

                    <div class="flex flex-col md:flex-row items-center gap-2">
                        <div class="flex gap-2">
                            <span class="bg-base-300 p-2 w-10 rounded dnd-handle cursor-move flex-none text-center">
                                <i class="inline-block {{ $setup['custom_icon'] ?? $setup['icon'] }}" aria-hidden="true"></i>
                            </span>
                            <input type="text" class="form-control" name="{{ $name }}_icon" value="{{ $setup['custom_icon'] ?? null }}" placeholder="{{ $setup['icon'] }}" maxlength="50" data-paste="fontawesome" />
                        </div>
                        <input type="text" class="form-control grow" name="{{ $name }}_label" value="{{ $setup['custom_label'] ?? null }}" placeholder="{{ $setup['label'] ?? __($setup['label_key'])  }}" maxlength="90" />
                        <span class="text-muted text-sm hidden md:!inline">({{ $setup['label'] ?? __($setup['label_key']) }})</span>
                        <input type="hidden" name="order[{{ $name }}]" value="1" />
                    </div>

                    @if (empty($setup['children']))
                        @continue
                    @endif

                    <input type="hidden" name="order[{{ $name }}_start]" value="1" />
                    {!! Form::hidden('section_' . $name . '_start', 1) !!}
                    <ul class="list-none mt-2 m-0 p-0 pl-4 sidebar-sortable nested-sortable basis-full">
                        @foreach ($setup['children'] as $childName => $child)
                            <li class="flex md:items-center flex-wrap mb-2 @if (\Illuminate\Support\Arr::get($child, 'disabled') === true) alert-warning @endif" id="{{ $childName }}">
                                <p class="text-muted text-sm visible md:hidden mb-0 basis-full">({{ $child['label'] ?? __($child['label_key'])}})</p>

                                <div class="flex flex-col md:flex-row items-center gap-2">
                                    <div class="flex gap-2">
                                        <span class="bg-base-300 p-2 w-10 text-center flex-none rounded dnd-handle cursor-move">
                                            <i class="inline-block w-6 {{ $child['custom_icon'] ?? $child['icon'] }}" aria-hidden="true"></i>
                                        </span>
                                        <input type="text" class="form-control" name="{{ $childName }}_icon" value="{{ $child['custom_icon'] ?? null }}" placeholder="{{ $child['icon'] ?? null }}" data-paste="fontawesome" maxlength="50" />
                                    </div>
                                    <input type="text" class="form-control" name="{{ $childName }}_label" value="{{ $child['custom_label'] ?? null }}" placeholder="{{ $child['label'] ?? __($child['label_key']) }}" maxlength="90" />
                                    <span class="text-muted text-sm hidden md:!inline grow flex-no-wrap">(
                                        {{ $child['label'] ?? __($child['label_key']) }}
                                        @if (\Illuminate\Support\Arr::get($child, 'disabled') === true)
                                            <i class="fa-solid fa-exclamation-triangle" aria-hidden="true" data-toggle="tooltip" data-title="{{ __('campaigns.modules.permission-disabled') }}"></i>
                                        @endif
                                        )
                                    </span>
                                </div>
                                <input type="hidden" name="order[{{ $childName }}]" value="1" />
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="order[{{ $name }}_end]" value="1" />
                    {!! Form::hidden('section_' . $name . '_end', 1) !!}
                </li>
            @endforeach
            </ul>
            <div class="text-right">
                <a href="#" class="btn2 btn-error btn-outline pull-left" data-toggle="dialog" data-target="reset-confirm">
                    <x-icon class="trash"></x-icon>
                    {{ __('campaigns/sidebar.actions.reset') }}
                </a>
                <button type="submit" class="btn2 btn-primary">
                    <x-icon class="save"></x-icon>
                    {{ __('crud.save') }}
                </button>
            </div>
        </x-box>
        {!! Form::close() !!}
        @endif
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
                    $campaign
                ]
            ]) !!}
                <x-buttons.confirm type="danger" full="true" outline="true">
                    {{ __('crud.click_modal.confirm') }}
                </x-buttons.confirm>
            {!! Form::close() !!}
        </div>
    </x-dialog>
@endsection

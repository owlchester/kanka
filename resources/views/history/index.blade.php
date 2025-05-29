<?php
    /** @var \App\Models\EntityLog $log */
?>
@extends('layouts.app', [
    'title' => __('history.title'),
    'breadcrumbs' => [['url' => route('history.index', $campaign), 'label' => __('history.title')]],
    'bodyClass' => 'campaign-history',
    'mainTitle' => false,
    'centered' => true,
])

@section('content')
    <x-grid type="1/1">
    @if (!$superboosted)
        <x-cta :campaign="$campaign" superboost="true">
            <p>{{ __('history.cta') }}</p>
        </x-cta>
    @else
        <x-tutorial code="history" doc="https://docs.kanka.io/en/latest/features/history.html">
            <p>{!! __('history.helpers.base', ['amount' => 3]) !!}</p>
        </x-tutorial>
    @endif

    @if ($superboosted)
        <x-form :action="['history.index', $campaign]" method="GET" class="history-filters flex flex-col gap-5">
        <div class="flex items-center flex-row-reverse gap-2">
            <div class="field flex-none">
                <x-forms.select name="action" :options="$actions" :selected="$action" class="w-full" />
            </div>
            <div class="field flex-none">
                <select class="" name="user">
                    <option value="">{{ __('history.filters.all-users') }}</option>
                    @foreach ($users as $member)
                        <option value="{{ $member->user_id }}" @if (isset($user) && $user == $member->user_id) selected="selected" @endif>{!! $member->user->name !!}</option>
                    @endforeach
                </select>
            </div>
            @if (count($filters) > 0)
                <div class="flex-none">
                    <a href="{{ route('history.index', $campaign) }}" role="button" class="btn2 btn-sm">{{ __('crud.actions.reset') }}</a>
                </div>
            @endif
            <div class="flex-none filters-loading hidden">
                <x-icon class="load" />
            </div>
        </div>
        </x-form>
    @endif

    @if ($models->count() > 0)
        @php $count = 0; @endphp
        @foreach ($models as $log)
            @if ($log->action < 7 || $log->post)
                @if ($log->day() !== $previous)
                    @if ($previous !== null) </div> @endif
                    <div class="font-bold">{{ $log->created_at->format('M d, Y') }}</div>
                    <div class="rounded bg-box border border-b-0 ">
                @endif
                <div class="p-2 border-solid border-b" x-data="{opened: false}">
                    <div class="flex justify-center items-center gap-2 {{ $count > 0 && !$superboosted ? 'blur' : null }}">
                        <div class="flex-none rounded-full {{ $log->actionBackground() }} inline-block text-center text-xs p-1 h-6 w-6 ">
                            <x-icon class="fa-solid {{ $log->actionIcon() }}" />
                        </div>
                        <div class="grow">
                            @if ($superboosted || $count === 0)
@php
$postLink = null;
if (!$log->entity) {
    $entityLink = '<a href="' . route('recovery', $campaign) . '">' . __('history.unknown.entity') . '</a>';
} else {
    $entityLink = \Illuminate\Support\Facades\Blade::renderComponent(
        new \App\View\Components\EntityLink($log->entity, $campaign)
    );
}
@endphp
                                {!! __('history.log.' . $log->actionCode(), [
                                    'user' => $log->userLink(),
                                    'entity' => $entityLink,
                                ]) !!}
                                @if ($log->post) -
                                    @if ($log->entity) <a href="{{ route('entities.show', [$campaign, $log->entity, '#post-' . $log->post->id]) }}">{!! $log->post->name !!}</a>
                                    @else
                                        {!! $log->post->name !!}
                                    @endif
                               @endif
                                @if ($log->impersonator)
                                    <span class="ml-5 text-warning">
                                        <x-icon class="fa-solid fa-exclamation-triangle" />
                                    {{ __('entities/logs.impersonated', ['name' => $log->impersonator->name]) }}
                                    </span>
                                @endif
                            @else
                            {{ \Illuminate\Support\Str::random(30) }} <a href="#" class="cursor-none">changes</a>
                            @endif
                        </div>
                        @if(!empty($log->changes))
                            <div class="flex-end">
                                <span class="btn2 btn-xs btn-outline" @click="opened = !opened">
                                    <x-icon class="fa-regular fa-eye" show="!opened" />
                                    <x-icon class="fa-regular fa-eye-slash" show="opened" />
                                    {{ __('entities/logs.actions.reveal') }}
                                </span>
                            </div>
                        @endif
                        <div class="text-xs text-muted flex-end text-right">
                            @if ($superboosted || $count === 0)
                                <span data-toggle="tooltip" data-title="{{ $log->created_at }} UTC">
                                    {{ $log->created_at->diffForHumans() }}
                                </span>
                            @else
                                Time since change
                            @endif
                        </div>
                    </div>
                    @if (!empty($log->changes) && $superboosted)
                    <div x-show="opened" class="py-2 flex flex-col gap-2">
                        <p class="text-neutral-content">{{ __('history.helpers.changes') }}</p>
                        @foreach ($log->changes as $attribute => $value)
                            @if (is_array($value)) @continue @endif
                            <div class="flex">
                                <div class="flex-initial w-32 font-bold" data-attribute="{{ $attribute }}">
                                    {!! $log->attributeKey($log->entity->entityType->pluralCode(), $attribute) !!}
                                </div>
                                <div class="flex-1 break-all">
                                    @if (\Illuminate\Support\Str::contains($attribute, ['has_', 'is_']))
                                        @if ($value) {{ __('general.yes') }} @else {{ __('general.no') }} @endif
                                    @elseif (empty($value))
                                        <i>{{ __('history.empty') }}</i>
                                    @else
                                        {!! $value !!}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @php $previous = $log->day(); $count++; @endphp
            @endif
        @endforeach
        </div>
    @else
        <x-alert type="warning">
            {{ __('history.filters.no-results') }}
        </x-alert>
    @endif

    @if ($superboosted)
        <div class="text-right">
            {!! $models->appends($filters)->onEachSide(0)->links() !!}
        </div>
    @endif

    </x-grid>
@endsection

@section('scripts')

    @vite('resources/js/history.js')
@endsection

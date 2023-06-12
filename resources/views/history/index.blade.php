<?php
    /** @var \App\Models\EntityLog $log */
?>
@extends('layouts.app', [
    'title' => __('history.title'),
    'breadcrumbs' => [['url' => route('history.index'), 'label' => __('history.title')]],
    'bodyClass' => 'campaign-history',
    'mainTitle' => false,
])

@section('content')
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
        {!! Form::open(['method' => 'GET', 'route' => 'history.index', 'class' => 'history-filters']) !!}
        <div class="flex items-center flex-row-reverse mb-5 gap-2">
            <div class="flex-none">
                {!! Form::select('action', $actions, $action, ['class' => 'form-control']) !!}
            </div>
            <div class="flex-none">
                <select class="form-control" name="user">
                    <option value="">{{ __('history.filters.all-users') }}</option>
                    @foreach ($users as $member)
                        <option value="{{ $member->user_id }}" @if (isset($user) && $user == $member->user_id) selected="selected" @endif>{!! $member->user->name !!}</option>
                    @endforeach
                </select>
            </div>
            @if (count($filters) > 0)
                <div class="flex-none">
                    <a href="{{ route('history.index') }}" role="button" class="btn2 btn-sm">{{ __('crud.actions.reset') }}</a>
                </div>
            @endif
            <div class="flex-none filters-loading" style="display: none">
                <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
            </div>
        </div>
        {!! Form::close() !!}
    @endif

    @if ($models->count() > 0)
        @foreach ($models as $log)
            @if ($log->action < 7 || $log->post)
                @if ($log->day() !== $previous)
                    @if ($previous !== null) </div> @endif
                    <div class="{{ !$superboosted ? 'blur' : null }} font-bold mb-2">{{ $log->created_at->format('M d, Y') }}</div>
                    <div class="rounded bg-box mb-5 border border-b-0 ">
                @endif
                <div class="p-2 border-solid border-b {{ !$superboosted ? 'blur' : null }}">
                    <div class="flex justify-center items-center gap-2">
                        <div class="flex-none rounded-full {{ $log->actionBackground() }} inline-block text-center text-xs p-1 h-6 w-6 ">
                            <i class="fa-solid {{ $log->actionIcon() }}" aria-hidden="true"></i>
                        </div>
                        <div class="flex-grow">
                            @if ($superboosted)
                                {!! __('history.log.' . $log->actionCode(), [
                                    'user' => $log->userLink(),
                                    'entity' => $log->entityLink(),
                                    'post' => $log->post?->name,
                                ]) !!}
                                @if ($log->impersonator)
                                    <span class="ml-5 text-warning">
                                    <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ __('entities/logs.impersonated', ['name' => $log->impersonator->name]) }}
                                        </span>
                                @endif
                            @else
                            {{ \Illuminate\Support\Str::random(30) }} <a href="#" class="cursor-none">changes</a>
                            @endif
                        </div>
                        @if(!empty($log->changes))
                            <div class="flex-end">
                                <a href="#log-{{ $log->id }}" data-toggle="collapse">
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    {{ __('history.actions.show-old') }}
                                </a>
                            </div>
                        @endif
                        <div class="text-xs text-muted flex-end text-right">
                            @if ($superboosted)
                                <span data-toggle="tooltip" title="{{ $log->created_at }} UTC">
                                    {{ $log->created_at->diffForHumans() }}
                                </span>
                            @else
                                Time since change
                            @endif
                        </div>
                    </div>
                    @if (!empty($log->changes) && $superboosted)
                    <div id="log-{{ $log->id }}" class="collapse !visible my-5">
                        <p class="text-muted">{{ __('history.helpers.changes') }}</p>
                        @foreach ($log->changes as $attribute => $value)
                            @if (is_array($value)) @continue @endif
                            <div class="flex mb-2">
                                <div class="flex-initial w-32 font-bold" data-attribute="{{ $attribute }}">
                                    {!! $log->attributeKey($log->entity->pluralType(), $attribute) !!}
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
                @php $previous = $log->day(); @endphp
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
@endsection

@section('scripts')

    @vite('resources/js/history.js')
@endsection

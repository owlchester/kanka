<?php /** @var \App\Models\EntityLog $log */ ?>
<div class="entity-logs">
    <div class="flex flex-col gap-2 lg:gap-5">
        <x-form :action="['entities.logs', $campaign, $entity]" method="GET">
            <div class="flex gap-2 justify-between">
                <div class="flex gap-2 items-center">
                    <input type="text" name="q"  class="grow" value="{!! old('q', htmlentities($q)) !!}" placeholder="{{ __('entities/logs.filters.keywords') }}" />
                    <x-forms.select name="action" :options="$actions" :selected="$action" />
                </div>
                <button class="btn2 btn-primary btn-sm">
                    {{ __('crud.actions.apply') }}
                </button>
            </div>
        </x-form>
        @foreach ($logs as $log)
            <div class="rounded p-4 shadow-xs bg-box entity-log flex flex-col gap-2" x-data="{ opened: @if (!$expanded) false @else true @endif }">
                <div class="log-title flex gap-2 justify-between">
                    <div class="action flex gap-2 items-center">
                        @if ($log->isPost())
                            <a href="{{ route('entities.show', [$campaign, $entity, '#post-' . $log->parent->id]) }}" data-title="{{ __('entities/logs.tooltips.post') }}" data-toggle="tooltip" class="text-link">
                                {!! $log->parent->name !!}
                            </a>
                            <x-icon class="fa-regular fa-chevron-right" />
                        @endif
                        <span class="font-bold ">{!! __('entities/logs.actions.' . $log->actionCode()) !!}</span>
                    </div>
                    <div class="text-xs">
                        <span data-title="{{ $log->created_at }} UTC" data-toggle="tooltip" class="text-neutral-content">
                            {{ $log->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-2 justify-between">
                    <div class="log-author">
                        @if ($log->user)
                            <x-users.link :user="$log->user" class="w-10 h-10" />
                        @else
                            <span class="text-italic unknown-author">
                                {{  __('crud.history.unknown') }}
                            </span>
                        @endif

                        @if ($log->impersonator)
                            <span class="impersonator">
                                ({{ __('entities/logs.impersonated', ['name' => $log->impersonator->name]) }})
                            </span>
                        @endif
                    </div>
                    <div class="">
                        @if ($campaign->superboosted() && !empty($log->changes))
                            <a @click="opened = !opened" class="btn2 btn-xs btn-outline">
                                <x-icon class="fa-regular fa-eye" />
                                {{ __('entities/logs.actions.reveal') }}
                            </a>
                        @elseif (!$campaign->superboosted())
                            <a @click="opened = !opened" class="btn2 btn-sm btn-outline">
                                <x-icon class="fa-regular fa-eye" />
                                {{ __('entities/logs.actions.reveal') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="log-cta" x-show="opened" id="log-cta-{{ $log->id }} x-cloak">
                    @if ($campaign->superboosted() && !empty($log->changes))
                        <p class="text-neutral-content">{{ __('history.helpers.changes') }}</p>
                        <ul>
                            @foreach ($log->changes as $attribute => $value)
                                @if (is_array($value)) @continue @endif
                                <li>
                                    <span class="log-field">
                                        {!! $log->attributeKey($transKey, $attribute) !!}@if (!empty($value) || $log->isBoolean($attribute)):@endif
                                    </span>
                                    <span class="log-value break-all">
                                                @if ($log->isBoolean($attribute))
                                            @if ($value) {{ __('general.yes') }} @else {{ __('general.no') }} @endif
                                        @elseif (!empty($value))
                                            {!! $value !!}
                                        @endif
                                            </span>
                                </li>
                            @endforeach
                        </ul>
                    @elseif (!$campaign->superboosted())
                        <div class="flex flex-col gap-2">
                            <x-helper>
                                <p>
                                    <x-icon class="premium" />
                                    {!! __('entities/logs.call-to-action', ['amount' => config('entities.logs')]) !!}
                                </p>
                            </x-helper>
                            @can('boost', auth()->user())
                                <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="btn2 bg-boost text-white">
                                    {!! __('settings/premium.actions.unlock', ['campaign' => $campaign->name]) !!}
                                </a>
                            @else
                                <a href="{{ \App\Facades\Domain::toFront('premium')  }}" class="btn2 bg-boost text-white">
                                    {!! __('callouts.premium.learn-more') !!}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        @if ($logs->hasPages())
            {{ $logs->onEachSide(0)->links() }}
        @endif
    </div>
</div>

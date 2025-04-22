<?php
/**
 * @var \App\Models\UserLog $log
 * @var \Illuminate\Support\Collection $users
 */
?>
<x-helper>
    {!! __('campaigns/logs.helpers.list', ['amount' => '<code>' . $premium . '</code>']) !!}
</x-helper>

<x-box class="rounded-2xl">
<table  class="table table-hover table-condensed">
    <thead>
    <tr>
        <th>{{ __('history.fields.who') }}</th>
        <th>{{ __('history.fields.module') }}</th>
        <th>{{ __('history.fields.action') }}</th>
        <th>{{ __('history.fields.details') }}</th>
        <th>{{ __('history.fields.when') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($logs as $log)
        @if ($log->requiresPremium())
            <tr>
                <td colspan="4" class="text-neutral-content text-xs">
                    <span class="">
                        {{ __('campaigns/logs.premium.helper', ['amount' => $cutoff]) }}
                    </span>
                    @if (auth()->check() && auth()->user()->hasBoosters())
                        <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="">
                            {!! __('callouts.premium.unlock', ['campaign' => $campaign->name]) !!}
                        </a>
                    @else
                        <a href="https://kanka.io/premium" class="">
                            {!! __('callouts.premium.learn-more') !!}
                        </a>
                    @endif
                </td>
                <td>
                <span data-toggle="tooltip" data-title="{{ $log->created_at }} UTC">
                    {{ $log->created_at->diffForHumans() }}
                </span>
                </td>
            </tr>
        @else
        <tr>
            <td>
                @if ($log->user)
                    {!! $log->user->name !!}
                @else
                    <span>[deleted user]</span>
                @endif

                @if ($log->impersonator)
                    <span class="text-xs text-neutral-content" data-toggle="tooltip" data-title="{{ __('entities/logs.impersonated', ['name' => $log->impersonator->name]) }}">
                        ({!! $log->impersonator->name !!})
                    </span>
                @endif
            </td>
            <td>
                {{ \Illuminate\Support\Arr::get($log->data, 'module') }}
            </td>
            <td>
                {{ \Illuminate\Support\Arr::get($log->data, 'action') }}
            </td>
            <td>
                @foreach ($log->data as $key => $val)
                    @if (in_array($key, ['module', 'action'])) @continue @endif
                        <div class="text-xs">
                            {{ $key }}: {{ $val }}
                        </div>
                @endforeach
            </td>
            <td>
                <span data-toggle="tooltip" data-title="{{ $log->created_at }} UTC">
                    {{ $log->created_at->diffForHumans() }}
                </span>
            </td>
        </tr>
       @endif
    @endforeach
    </tbody>
</table>
</x-box>
{!! $logs->links() !!}

<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\UserLog $log
 * @var \Illuminate\Support\Collection $users
 */
?>
<p>{!! __('campaigns/logs.helpers.list', ['amount' => '<code>' . $premium . '</code>']) !!}</p>

<table  class="table table-hover table-condensed bg-box rounded">
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
        @if ($log->requiresPremium() && !$campaign->premium())
            <tr>
                <td colspan="4" class="text-neutral-content text-xs">
                    <span class="">
                        <x-icon class="premium" />
                        {!! __('campaigns/logs.premium.helper', ['amount' => '<strong>' . $cutoff . '</strong>']) !!}
                    </span>
                </td>
                <td>
                    <x-since :date="$log->created_at" />
                </td>
            </tr>
        @else
        <tr>
            <td>
                @if ($log->user)
                    <a href="{{ route('users.profile', $log->user) }}">
                    {!! $log->user->name !!}
                    </a>
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
            <td class="">
                <div class="flex flex-wrap gap-1">
                @foreach ($log->data as $key => $val)
                    @if (in_array($key, ['module', 'action']) || is_array($key)) @continue @endif
                        <div class="text-xs rounded-2xl px-2 py-1 border border-base-300">
                            {{ $key }}: {{ $val }}
                        </div>
                @endforeach
                </div>
            </td>
            <td>
                <x-since :date="$log->created_at" />
            </td>
        </tr>
       @endif
    @endforeach
    </tbody>
</table>
{!! $logs->links() !!}

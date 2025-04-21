<?php
/**
 * @var \App\Models\UserLog $log
 * @var \Illuminate\Support\Collection $users
 */
?>
<x-box>
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
        <tr>
            <td>
                {!! $users->get($log->user_id)->name !!}
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
    @endforeach
    </tbody>
</table>
</x-box>
{!! $logs->links() !!}

<?php /** @var \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Pagination\LengthAwarePaginator  $notifications */
use \Illuminate\Support\Arr;
use \Illuminate\Support\Str;
?>
@extends('layouts.app', [
    'title' => __('notifications.index.title'),
    'breadcrumbs' => false,
])

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex gap-2 mb-3">
            <h1 class="grow">{{ __('notifications.index.title') }}</h1>

            @if ($notifications->count() >= 0)
            <div class="flex-none self-end">
                <x-buttons.confirm type="danger" target="delete-confirm-notifications" size="sm">
                    <x-icon class="trash" />
                    <span>{{ __('notifications.clear.action') }}</span>
                </x-buttons.confirm>
            </div>
            @endif
        </div>

        <x-box :padding="0">
            @if ($notifications->count() === 0)
                <x-helper>
                    <p>{{ __('notifications.no_notifications') }}</p>
                </x-helper>
            @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <tbody>
                    <?php /** @var \Illuminate\Notifications\DatabaseNotification $notification */?>
                    @foreach ($notifications as $notification)
                        <tr class="@if(!$notification->read()) info @endif">
                            <td>
                            @if (!empty($notification->data['icon']))
                                <i class="fa-solid fa-{{ $notification->data['icon'] }} text-{{ $notification->data['colour'] }}"></i>
                                    @if(Arr::has($notification->data['params'], 'link'))
        @php
        $url = $notification->data['params']['link'];
        if (!Str::startsWith($url, 'http')) {
            $url = url(app()->getLocale() . '/' . $url);
        }
        // Fix to new links?
        //$url = \Illuminate\Support\Str::replace(['/campaign/'], ['/w/'], $url);
        @endphp
                                        <a href="{{ $url }}">
                                            {!! __('notifications.' . $notification->data['key'], $notification->data['params']) !!}
                                        </a>
                                    @elseif (Arr::has($notification->data['params'], 'route'))
                                        <a href="{{ route($notification->data['params']['route']) }}">
                                            {!! __('notifications.' . $notification->data['key'], $notification->data['params']) !!}
                                        </a>
                                    @else
                                        {!! __('notifications.' . $notification->data['key'], $notification->data['params']) !!}
                                    @endif
                                @else
                                    <p>{!! __('notifications.' . $notification->data['key'] . '.body')!!}</p>
                                @endif
                            </td>
                            <td class="text-right">
                                <span class="text-muted " title="{{ $notification->created_at }}">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        </x-box>
        @if ($notifications->hasPages())
            {!! $notifications->links() !!}
        @endif
    </div>
    <input type="hidden" id="notification-clear" />
@endsection

@section('modals')
    <x-dialog id="delete-confirm-notifications" :title="__('notifications.clear.title')">
        <p class="">
            {{ __('crud.delete_modal.permanent') }}
        </p>

        <div class="grid grid-cols-2 gap-2">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>
            <x-form :action="['notifications.clear-all']" id="notifications-clear">
                <x-buttons.confirm type="danger" full="true" ouline="true">
                    <x-icon class="trash" />
                    <span>{{ __('crud.remove') }}</span>
                </x-buttons.confirm>
            </x-form>
        </div>
    </x-dialog>
@endsection

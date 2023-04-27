<?php /** @var \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Pagination\LengthAwarePaginator  $notifications */?>
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
                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                    <span>{{ __('notifications.clear.action') }}</span>
                </x-buttons.confirm>
            </div>
            @endif
        </div>

        <div class="rounded shadow-xs bg-box">
            @if ($notifications->count() === 0)
                <p class="help-block p-4">{{ __('notifications.no_notifications') }}</p>
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
                                    @if(\Illuminate\Support\Arr::has($notification->data['params'], 'link'))
        @php
        $url = $notification->data['params']['link'];
        if (!\Illuminate\Support\Str::startsWith($url, 'http')) {
            $url = url(app()->getLocale() . '/' . $url);
        }
        @endphp
                                        <a href="{{ $url }}">
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
            @if ($notifications->hasPages())
                <div class="text-right">
                    {!! $notifications->links() !!}
                </div>
           @endif

        @endif
        </div>
    </div>
    <input type="hidden" id="notification-clear" />
@endsection

@section('modals')
    <x-dialog id="delete-confirm-notifications" :title="__('notifications.clear.title')">
        <p class="mb-2">
            {{ __('crud.delete_modal.permanent') }}
        </p>

        <div class="grid grid-cols-2 gap-2">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>
            {!! Form::open([
                'method' => 'POST',
                'route' => 'notifications.clear-all',
                'id' => 'notifications-clear'
            ]) !!}
                <x-buttons.confirm type="danger" full="true" ouline="true">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                    <span>{{ __('crud.remove') }}</span>
                </x-buttons.confirm>
            {!! Form::close() !!}
        </div>
    </x-dialog>
@endsection

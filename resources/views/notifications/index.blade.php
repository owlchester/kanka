<?php /** @var \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Pagination\LengthAwarePaginator  $notifications */?>
@extends('layouts.app', [
    'title' => __('notifications.index.title'),
    'breadcrumbs' => false,
])

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="mb-3">{{ __('notifications.index.title') }}</h1>

        <div class="rounded p-4 bg-box">
            @if ($notifications->count() === 0)
                <p class="help-block">{{ __('notifications.no_notifications') }}</p>
            @else

            <div class="text-right mb-5">
                <button class="btn btn-danger delete-confirm btn-sm" data-toggle="modal"
                        data-target="#delete-confirm-notifications" data-delete-target="notifications-clear">
                    <i class="fa-solid fa-trash-o"></i> {{ __('notifications.clear.action') }}
                </button>
            </div>
            <div class=" table-responsive">
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
        {!! Form::open([
    'method' => 'POST',
    'route' => 'notifications.clear-all',
    'id' => 'notifications-clear'
    ]) !!}
        {!! Form::close() !!}
        @endif
        </div>
    </div>
    <input type="hidden" id="notification-clear" />
@endsection

@section('modals')
    <div class="modal fade" id="delete-confirm-notifications" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-2xl">
                <div class="modal-body text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ __('notifications.clear.title') }}</h4>

                    <p class="mt-3">
                        {{ __('crud.delete_modal.permanent') }}
                    </p>

                    <div class="py-5">
                        <button type="button" class="btn px-8 rounded-full mr-5" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                        <button type="button" class="btn btn-danger delete-confirm-submit px-8 ml-5 rounded-full">
                            <span class="fa-solid fa-trash" aria-hidden="true"></span>
                            <span class="remove-button-label">{{ __('crud.remove') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

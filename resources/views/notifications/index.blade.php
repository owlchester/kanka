<?php /** @var \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Pagination\LengthAwarePaginator  $notifications */?>
@extends('layouts.app', [
    'title' => __('notifications.index.title'),
    'breadcrumbs' => false,
])

@section('content')
    @include('partials.errors')

    @if ($notifications->count() === 0)
        <p class="help-block">{{ __('notifications.no_notifications') }}</p>
    @else
    <div class="box box-solid">
        <div class="box-header">
            <div class="box-tools">
                <button class="btn btn-danger delete-confirm btn-sm" data-toggle="modal"
                        data-target="#delete-confirm-notifications" data-delete-target="notifications-clear">
                    <i class="fa fa-trash-o"></i> {{ __('notifications.clear.action') }}
                </button>
            </div>
        </div>
        <div class="box-body">

            <div class=" table-responsive">
            <table class="table table-hover">
                <tbody>
                <?php /** @var \Illuminate\Notifications\DatabaseNotification $notification */?>
                @foreach ($notifications as $notification)
                    <tr class="@if(!$notification->read()) info @endif">
                        <td>
                        @if (!empty($notification->data['icon']))
                            <i class="fa fa-{{ $notification->data['icon'] }} text-{{ $notification->data['colour'] }}"></i>
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
        </div>
        @if ($notifications->hasPages())
        <div class="box-footer text-right">
            {!! $notifications->links() !!}
        </div>
        @endif
    </div>
    {!! Form::open([
'method' => 'POST',
'route' => 'notifications.clear-all',
'id' => 'notifications-clear'
]) !!}
    {!! Form::close() !!}
    @endif

    <input type="hidden" id="notification-clear" />
@endsection

@section('modals')
    <div class="modal modal-danger fade" id="delete-confirm-notifications" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('crud.delete_modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p id="delete-confirm-text">
                        {{ __('notifications.clear.confirm') }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button type="button" class="btn btn-outline delete-confirm-submit">
                        <span class="fa fa-trash"></span>
                        <span class="delete-button-label">{{ __('crud.delete_modal.delete') }}</span>
                        <span class="remove-button-label" style="display: none">{{ __('crud.remove') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

<?php /** @var \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Pagination\LengthAwarePaginator  $notifications */

?>
@extends('layouts.app', [
    'title' => __('notifications.index.title'),
    'breadcrumbs' => false,
])

@section('content')
    <div class="max-w-4xl mx-auto flex flex-col gap-4">
        <div class="flex gap-2 items-center justify-between">
            <h1 class="grow text-2xl">{{ __('notifications.index.title') }}</h1>

            @if ($notifications->count() >= 0)
            <x-buttons.confirm type="danger" target="delete-confirm-notifications" size="sm">
                <x-icon class="trash" />
                <span>{{ __('notifications.clear.action') }}</span>
            </x-buttons.confirm>
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
                    @foreach ($notifications as $notification)
                        @include('notifications._notification')
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

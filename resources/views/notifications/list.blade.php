<?php /** @var \Illuminate\Notifications\DatabaseNotification $notification */?>
@foreach ($notifications as $notification)
    @if (!empty($notification->data['icon']))
        <li>
            <a href="{{ route('notifications') }}">
                @if(!$notification->read())
                    <i class="fa fa-circle text-info" title="{{ __('notifications.unread') }}"></i>
                @endif
                <i class="fa fa-{{ $notification->data['icon'] }} text-{{ $notification->data['colour'] }}"></i> {{ trans('notifications.' . $notification->data['key'], $notification->data['params']) }}
            </a>
        </li>
    @endif
@endforeach

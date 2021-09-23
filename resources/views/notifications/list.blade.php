<?php /** @var \Illuminate\Notifications\DatabaseNotification $notification */?>
@foreach ($notifications as $notification)
    <li>
        @php
        $url = \Illuminate\Support\Arr::get($notification->data['params'], 'link', route('notifications'));
        @endphp
        <a href="{{ $url }}">
            @if(!$notification->read())
            <i class="fa fa-circle text-info" title="{{ __('notifications.unread') }}"></i>
            @endif
            @if (!empty($notification->data['icon']))
            <i class="fa fa-{{ $notification->data['icon'] }} text-{{ $notification->data['colour'] }}"></i>
            @endif
            {!! __('notifications.' . $notification->data['key'], $notification->data['params']) !!}
        </a>
    </li>
@endforeach

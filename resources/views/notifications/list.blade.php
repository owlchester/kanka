<?php /** @var \Illuminate\Notifications\DatabaseNotification $notification */?>
@foreach ($notifications as $notification)
    <li>
        @php
        $url = \Illuminate\Support\Arr::get($notification->data['params'], 'link', route('notifications'));
        if (!\Illuminate\Support\Str::startsWith($url, 'http')) {
            $url = url(app()->getLocale() . '/' . $url);
        }
        @endphp
        <a href="{{ $url }}">
            @if(!$notification->read())
            <i class="fa-solid fa-circle text-info" title="{{ __('notifications.unread') }}"></i>
            @endif
            @if (!empty($notification->data['icon']))
            <i class="fa-solid fa-{{ $notification->data['icon'] }} text-{{ $notification->data['colour'] }}"></i>
            @endif
            {!! __('notifications.' . $notification->data['key'], $notification->data['params']) !!}
        </a>
    </li>
@endforeach

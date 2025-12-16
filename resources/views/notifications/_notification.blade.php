<?php /** @var \Illuminate\Notifications\DatabaseNotification $notification */
use \Illuminate\Support\Arr;
use \Illuminate\Support\Str;
?>
<tr class="@if(!$notification->read()) info @endif">
    <td>
        @if (!empty($notification->data['icon']))
            <i class="fa-regular fa-{{ $notification->data['icon'] }} text-{{ $notification->data['colour'] }}"></i>
            @if(Arr::has($notification->data['params'], 'link'))
                @php
                    $url = $notification->data['params']['link'];
                    if (!Str::startsWith($url, 'http')) {
                        $url = url(app()->getLocale() . '/' . $url);
                    }
                    // Fix to new links?
                    //$url = \Illuminate\Support\Str::replace(['/campaign/'], ['/w/'], $url);
                @endphp
                <a href="{{ $url }}" class="text-link">
                    {!! __('notifications.' . $notification->data['key'], $notification->data['params']) !!}
                </a>
            @elseif (Arr::has($notification->data['params'], 'route'))
                <a href="{{ route($notification->data['params']['route']) }}" class="text-link">
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
        <x-since :date="$notification->created_at" />
    </td>
</tr>

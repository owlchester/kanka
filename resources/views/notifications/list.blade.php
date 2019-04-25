@foreach ($notifications as $notification)
    @if (!empty($notification->data['icon']))
        <li>
            <a href="{{ route('notifications') }}">
                <i class="fa fa-{{ $notification->data['icon'] }} text-{{ $notification->data['colour'] }}"></i> {{ trans('notifications.' . $notification->data['key'], $notification->data['params']) }}
            </a>
        </li>
    @endif
@endforeach
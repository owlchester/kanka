@extends('layouts.app', [
    'title' => trans('notifications.index.title'),
    'description' => trans('notifications.index.description'),
    'breadcrumbs' => [
        ['url' => route('notifications'), 'label' => trans('notifications.index.title')]
    ]
])

@section('content')
    @include('partials.errors')

    <div class="box box-solid">
        <div class="box-body">
            <table class="table table-hover">
                <tbody>
                @foreach ($r = Auth::user()->notifications()->paginate() as $notification)
                    <tr>
                        <td>
                            @if (!empty($notification->data['icon']))
                            <i class="fa fa-{{ $notification->data['icon'] }} text-{{ $notification->data['colour'] }}"></i> {!! trans('notifications.' . $notification->data['key'], $notification->data['params']) !!}
                            @else
                                <p>{!! trans('notifications.' . $notification->data['key'] . '.body')!!}</p>
                            @endif
                            <span class="text-muted pull-right">{{ $notification->created_at->diffForHumans() }}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $r->links() !!}

            @if (Auth::user()->notifications()->count() == 0)
                <p class="help-block">{{ trans('notifications.no_notifications') }}</p>
            @endif
        </div>
    </div>

    <input type="hidden" id="notification-clear" />
@endsection

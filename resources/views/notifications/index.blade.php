@extends('layouts.app', [
    'title' => trans('notifications.index.title'),
    'description' => trans('notifications.index.description'),
    'breadcrumbs' => [
        ['url' => route('notifications'), 'label' => trans('notifications.index.title')]
    ]
])

@section('content')
    @include('partials.errors')

    <div class="box">
        <div class="box-body">
            <table class="table table-hover">
                <tbody>
                @foreach ($r = Auth::user()->notifications()->paginate() as $notification)
                    <tr>
                        <td>
                            <i class="fa fa-{{ $notification->data['icon'] }} text-{{ $notification->data['colour'] }}"></i> {{ trans('notifications.' . $notification->data['key'], $notification->data['params']) }}

                            <span class="text-muted pull-right">{{ $notification->created_at }}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $r->links() !!}
        </div>
    </div>
@endsection

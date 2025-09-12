@extends('layouts.app', [
    'title' => __('whiteboards.index.title'),
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('content')

    <div class="flex gap-2 justify-between items-center">
        <h3>{{ __('whiteboards.index.title') }}</h3>
        <a href="{{ route('whiteboards.create', $campaign) }}" class="btn2 btn-primary">
            {{ __('whiteboards.actions.create') }}
        </a>
    </div>

    <table>

        <tbody>
        @foreach ($models as $whiteboard)
            <tr>
                <td>
                    <a href="{{ route('whiteboards.show', [$campaign, $whiteboard]) }}">
                        {{ $whiteboard->name }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $models->links() !!}
@endsection

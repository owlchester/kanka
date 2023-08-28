<x-grid type="1/1">
    @foreach ($model->participants as $participant)
        @if ($participant->isMember() || (auth()->check() && auth()->user()->can('view', $participant->entity())))
            @can('update', $model)
                {!! Form::open(['method' => 'DELETE', 'route' => ['conversations.conversation_participants.destroy', $campaign, $model, $participant]]) !!}
            @endcan
        <div class="grid grid-cols-2 items-center align-middle gap-5">
            <div class="">
                @if ($participant->isMember())
                    {{ $participant->entity()->name }}
                @else
                    <a href="{{ route('characters.show', [$campaign, $participant->entity()]) }}">{{ $participant->entity()->name }}</a>
                @endif
            </div>

            @can('update', $model)
                <button class="btn2 btn-error btn-outline btn-sm">
                    <x-icon class="trash"></x-icon>
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </button>
                {!! Form::close() !!}
            @endcan
        </div>
        @endif
    @endforeach
</x-grid>


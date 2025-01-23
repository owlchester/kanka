<x-grid type="1/1">
    @forelse ($model->participants as $participant)
        @if ($participant->isMember() || (auth()->check() && auth()->user()->can('view', $participant->entity())))
        <div class="grid grid-cols-2 items-center align-middle gap-5">
            <div class="">
                @if ($participant->isMember())
                    {{ $participant->entity()->name }}
                @else
                    <a href="{{ route('characters.show', [$campaign, $participant->entity()]) }}">{{ $participant->entity()->name }}</a>
                @endif
            </div>

            @can('update', $entity)
                <x-form method="DELETE" :action="['conversations.conversation_participants.destroy', $campaign, $model, $participant]">
                    <button class="btn2 btn-error btn-outline btn-sm">
                        <x-icon class="trash" />
                        <span class="sr-only">{{ __('crud.remove') }}</span>
                    </button>
                </x-form>
            @endcan
        </div>
        @endif
    @empty
        <p class="text-neutral-content">{{ __('conversations.hints.empty') }}</p>
    @endforelse


</x-grid>


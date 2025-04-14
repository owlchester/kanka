<?php /**
 * @var \App\Models\Conversation $model
 */?>
<x-grid type="1/1">
    <x-helper>
        {!! __('conversations.participants.helper', ['name' => $model->name]) !!}
    </x-helper>

    @forelse ($model->participants as $participant)
        @if ($participant->isMember() || (auth()->check() && auth()->user()->can('view', $participant->entity()->entity ?? false)))
        <div class="flex items-center gap-2 justify-between">
            @if ($participant->isMember())
                <span>{{ $participant->entity()->name }}</span>
            @else
                <a href="{{ route('characters.show', [$campaign, $participant->entity()]) }}">{{ $participant->entity()->name }}</a>
            @endif

            @can('update', $model->entity)
                <div>
                <x-form method="DELETE" :action="['conversations.conversation_participants.destroy', $campaign, $model, $participant]">
                    <button class="btn2 btn-error btn-outline btn-sm">
                        <x-icon class="trash" />
                        <span class="sr-only">{{ __('crud.remove') }}</span>
                    </button>
                </x-form>
                </div>
            @endcan
        </div>
        @endif
    @empty
        <x-helper>
            {{ __('conversations.hints.empty') }}
        </x-helper>
    @endforelse


</x-grid>


<?php /**
 * @var \App\Models\Conversation $model
 */?>
<x-grid type="1/1">
    <x-helper>
        <p>{!! __('conversations.participants.helper', ['name' => $model->name]) !!}</p>
    </x-helper>

    <div class="flex flex-col gap-2">
    @forelse ($model->participants as $participant)
        @if ($participant->isMember() || (auth()->check() && auth()->user()->can('view', $participant->entity()->entity ?? false)))
        <div class="flex items-center gap-2 justify-between hover:bg-base-200 rounded p-2">
            @if ($participant->isMember())
                <x-users.link :user="$participant->entity()" class="w-10 h-10" />
            @else
                <a href="{{ route('characters.show', [$campaign, $participant->entity()]) }}" class="flex items-center gap-2">
                    <div class="cover-background rounded-full h-10 w-10" style="background-image: url('{{ \App\Facades\Avatar::entity($participant->entity()->entity)->size(40)->fallback()->thumbnail() }}')"></div>
                    {!! $participant->entity()->name !!}
                </a>
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
            <p>{{ __('conversations.hints.empty') }}</p>
        </x-helper>
    @endforelse
    </div>


</x-grid>


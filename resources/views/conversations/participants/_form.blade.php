<?php /**
 * @var \App\Models\Conversation $model
 */?>
<x-grid type="1/1">
    <x-helper>
        <p>{!! __('conversations.participants.helper', ['name' => $model->name]) !!}</p>
    </x-helper>

    <div class="flex flex-col gap-2">
    @forelse ($model->participants as $participant)
        @if ($participant->isMember() || ($participant->entity() && auth()->check() && auth()->user()->can('view', $participant->entity())))
        <div class="flex items-center gap-2 justify-between hover:bg-base-200 rounded p-2">
            @if ($participant->isMember())
                <x-users.link :user="$participant->entity()" class="w-10 h-10" />
            @else
                <a href="{{ route('entities.show', [$campaign, $participant->entity()]) }}" class="flex items-center gap-2 text-link">
                    <div class="cover-background rounded-full h-10 w-10" style="background-image: url('{{ \App\Facades\Avatar::entity($participant->entity())->size(40)->fallback()->thumbnail() }}')"></div>
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

    <?php /** @var \App\Models\Conversation $model */?>
    @can('update', $model->entity)
        <?php $memberList = $campaign->membersList($model->participantsList(false, true)); ?>
        @if($model->forEntities() || count($memberList) > 0)
            <x-form :action="['conversations.conversation_participants.store', $campaign, $model]" class="flex gap-2">
            <div class="flex flex-col gap-2 w-full">
                <div class="w-full">
                    @if ($model->forEntities())
                        @include('cruds.fields.entity', ['allowNew' => false, 'name' => 'entity_ids[]', 'key' => 'entity', 'multiple' => true, 'label' => __('entities.entries'), 'skipPreset' => true])
                    @else
                        <x-forms.select name="user_ids[]" :options="$memberList" :selected="$source->user_id ?? $model->user_id ?? null" :multiple="true" />
                    @endif
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn2 btn-primary btn-sm">
                        <x-icon class="plus" /> {{ __('crud.add') }}
                    </button>
                </div>
            </div>
            <input type="hidden" name="conversation_id" value="{{ $model->id }}" />
            </x-form>
        @endif
    @endcan


</x-grid>

<?php /** @var \App\Models\Conversation $model */ ?>
@php
$conversation = $entity->child;
$viewer = auth()->user();
$canManage = $viewer?->can('update', $entity) ?? false;
$speakers = [];
if ($canManage && ! $conversation->is_closed) {
    foreach ($conversation->postingParticipants($viewer) as $speaker) {
        $speakers[] = ['id' => $speaker->id, 'name' => $speaker->name];
    }
}
$participantUrl = $canManage ? route('conversations.conversation_participants.index', [$campaign, $conversation]) : null;
$translations = json_encode([
 'edit' => __('crud.edit'),
 'copy' => __('crud.actions.copy'),
 'copied' => __('conversations.messages.copied'),
 'copy_failed' => __('conversations.messages.copy_failed'),
 'remove' => __('crud.remove'),
 'save' => __('crud.save'),
 'is_updated' => __('conversations.messages.is_updated'),
 'is_closed' => __('conversations.show.is_closed'),
 'load_previous' => __('conversations.messages.load_previous'),
'user_unknown' => __('crud.users.unknown'),
'cancel' => __('crud.cancel'),
 'confirm_delete' => __('conversations.messages.confirm_delete'),
 'request_failed' => __('conversations.messages.request_failed'),
 'messages' => __('conversations.fields.messages'),
 'participants' => __('conversations.fields.participants'),
 'empty' => __('conversations.messages.empty'),
 'first_message' => __('conversations.messages.first_message'),
 'loading' => __('conversations.messages.loading'),
 'retry' => __('conversations.messages.retry'),
 'refresh_failed' => __('conversations.messages.refresh_failed'),
 'no_speaker' => __('conversations.messages.no_speaker'),
 'speaking_as' => __('conversations.messages.speaking_as'),
 'message' => __('conversations.messages.placeholders.message'),
 'keyboard_hint' => __('conversations.messages.keyboard_hint'),
 'send' => __('conversations.messages.send'),
 'sending' => __('conversations.messages.sending'),
 'saving' => __('conversations.messages.saving'),
 'editing' => __('conversations.messages.editing'),
 'actions' => __('conversations.messages.actions'),
]);
@endphp

@section('entity-header-actions-override')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        @if ($canManage)
            <button
                type="button"
                class="btn2 btn-sm"
                data-toggle="dialog"
                data-url="{{ $participantUrl }}">
                <x-icon class="fa-solid fa-users" />
                {{ __('conversations.fields.participants') }} {{ $conversation->participants->count() }}
            </button>
            @include('entities.headers.toggle')
            @include('entities.headers.actions')
        @endif
    </div>
@endsection


<div class="entity-grid flex flex-col gap-5">

    @include('entities.components.header', [
        'entityHeaderActions' => 'entity-header-actions-override',
    ])

    <div class="entity-body flex flex-col md:flex-row gap-5">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5 min-w-0">
            <div
                class="box-conversation"
                id="conversation"
                data-api="{{ route('conversations.conversation_messages.index', [$campaign, $conversation]) }}"
                data-target="{{ $conversation->forEntities() ? 'entity' : 'user' }}"
                data-speakers="{{ json_encode($speakers) }}"
                data-closed="{{ $conversation->is_closed ? '1' : '0' }}"
                data-can-manage="{{ $canManage ? '1' : '0' }}"
                data-participants="{{ $participantUrl }}"
                data-send="{{ $canManage && ! $conversation->is_closed ? route('conversations.conversation_messages.store', [$campaign, $conversation]) : '' }}"
                data-trans="{{ $translations }}"
            >
                <p class="rounded-xl bg-base-100 p-6 text-sm" role="status">{{ __('conversations.messages.loading') }}</p>
            </div>

            @include('entities.components.posts')
        </div>

        @include('entities.components.pins')
    </div>
</div>

@section('scripts')
@parent
@vite('resources/js/conversation.js')
@endsection

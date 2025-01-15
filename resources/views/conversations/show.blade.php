<?php /** @var \App\Models\Conversation $model */ ?>
@php
$translations = json_encode([
'edit' => __('crud.edit'),
'remove' => __('crud.remove'),
'is_updated' => __('conversations.messages.is_updated'),
'is_closed' => __('conversations.show.is_closed'),
'load_previous' => __('conversations.messages.load_previous'),
'user_unknown' => __('crud.users.unknown'),
]);
@endphp

@section('entity-header-actions-override')
    <div class="header-buttons flex gap-2 items-center justify-end">
    @can('update', $entity)
            <a class="btn2 btn-sm" data-toggle="dialog-ajax" data-target="primary-dialog"
                    data-url="{{ route('conversations.conversation_participants.index', [$campaign, $entity->child]) }}">
                <x-icon class="fa-solid fa-users" />
                {{ __('conversations.fields.participants') }} {{ $entity->child->participants->count() }}
            </a>
            @include('entities.headers.toggle')
        @include('entities.headers.actions')
    @endcan
    </div>
@endsection


<div class="entity-grid flex flex-col gap-5">

    @include('entities.components.header', [
        'breadcrumb' => [
            Breadcrumb::entity($entity)->list(),
        ],
        'entityHeaderActions' => 'entity-header-actions-override',
    ])

    <div class="entity-body flex flex-col md:flex-row gap-5">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5 min-w-0">
            <div class="box-conversation" id="conversation">
                <conversation
                        id="{{ $entity->child->id }}"
                        api="{{ route('conversations.conversation_messages.index', [$campaign, $entity->child]) }}"
                        target="{{ $entity->child->forCharacters() ? 'character' : 'user'}}"
                        :targets="{{ $entity->child->jsonParticipants() }}"
                        :disabled="{{ ($entity->child->is_closed ? 'true' : 'false') }}"
                        send="{{ route('conversations.conversation_messages.store', [$campaign, $entity->child]) }}"
                        trans="{{ $translations }}"
                >
                </conversation>
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

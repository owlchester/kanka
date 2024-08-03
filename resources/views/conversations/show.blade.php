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
    @can('update', $model)
        <div class="header-buttons inline-block  flex gap-2 items-center justify-end">
            <a class="btn2 btn-sm" data-toggle="dialog-ajax" data-target="primary-dialog"
                    data-url="{{ route('conversations.conversation_participants.index', [$campaign, $model]) }}">
                <x-icon class="fa-solid fa-users"></x-icon>
                {{ __('conversations.fields.participants') }} {{ $model->participants->count() }}
            </a>
            @include('entities.headers.toggle')
            @can('update', $model)
                <a href="{{ $model->getLink('edit') }}" class="btn2 btn-primary btn-sm ">
                    <x-icon class="pencil"></x-icon> {{ __('crud.edit') }}
                </a>
            @endcan
            @can('post', [$model, 'add'])
                <a href="{{ route('entities.posts.create', [$campaign, $model->entity]) }}" class="btn2 btn-sm btn-new-post"
                   data-entity-type="post" data-toggle="tooltip" data-title="{{ __('crud.tooltips.new_post') }}">
                    <x-icon class="plus"></x-icon> {{ __('crud.actions.new_post') }}
                </a>
            @endcan
        </div>
    @endcan
@endsection


<div class="entity-grid flex flex-col gap-5">

    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            Breadcrumb::entity($model->entity)->list(),
        ],
        'entityHeaderActions' => 'entity-header-actions-override',
    ])

    <div class="entity-body flex flex-col md:flex-row gap-5">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5 min-w-0">
            <div class="box-conversation" id="conversation">
                <conversation
                        id="{{ $model->id }}"
                        api="{{ route('conversations.conversation_messages.index', [$campaign, $model]) }}"
                        target="{{ $model->forCharacters() ? 'character' : 'user'}}"
                        :targets="{{ $model->jsonParticipants() }}"
                        :disabled="{{ ($model->is_closed ? 'true' : 'false') }}"
                        send="{{ route('conversations.conversation_messages.store', [$campaign, $model]) }}"
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

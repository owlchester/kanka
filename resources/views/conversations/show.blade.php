<?php /** @var \App\Models\Conversation $model */ ?>

<div class="entity-grid">

    @include('entities.components.header_grid', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
            null
        ]
    ])

    @include($name . '._menu', ['active' => 'story'])

    <div class="entity-story-block">

        <div class="box box-solid">
            <div class="box-header">
                <div class="box-tools">
                    <button class="btn btn-default" data-toggle="ajax-modal" data-target="#entity-modal"
                            data-url="{{ route('conversations.conversation_participants.index', $model) }}">
                        <i class="fa fa-users"> {{ $model->participants->count() }}</i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="box-conversation" id="conversation">
                    <conversation
                            id="{{ $model->id }}"
                            api="{{ route('conversations.conversation_messages.index', $model) }}"
                            target="{{ $model->forCharacters() ? 'character' : 'user'}}"
                            :targets="{{ $model->jsonParticipants() }}"
                            :disabled="{{ ($model->is_closed ? 'true' : 'false') }}"
                            send="{{ route('conversations.conversation_messages.store', $model) }}"
                            trans="{{ $translations }}"
                    >
                    </conversation>
                </div>
            </div>
        </div>

        @include('entities.components.notes')
        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>

@section('scripts')
    @parent
    <script src="{{ mix('js/conversation.js') }}" defer></script>
@endsection

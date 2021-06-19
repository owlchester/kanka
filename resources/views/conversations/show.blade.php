<?php /** @var \App\Models\Conversation $model */ ?>
<div class="row">
    <div class="col-md-2">
        @include('conversations._menu', ['active' => 'story'])
    </div>

    <div class="col-md-8">

        <div class="box box-solid">
            <div class="box-body">
                <div class="box-conversation" id="conversation">
                    <conversation
                            id="{{ $model->id }}"
                            api="{{ route('conversations.conversation_messages.index', $model) }}"
                            target="{{ $model->target == \App\Models\Conversation::TARGET_CHARACTERS ? 'character' : 'user'}}"
                            :targets="{{ $model->jsonParticipants() }}"
                            :disabled="{{ ($model->is_closed ? 'true' : 'false') }}"
                            send="{{ route('conversations.conversation_messages.store', $model) }}"
                    >
                    </conversation>
                </div>
            </div>
        </div>

        @include('entities.components.notes')


        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="col-md-2">
        @include('entities.components.pins')
    </div>
</div>

@section('styles')
    @parent
    <link href="{{ mix('css/conversation.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/conversation.js') }}" defer></script>
@endsection

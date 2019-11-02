<?php /** @var \App\Models\Conversation $model */ ?>
<div class="row">
    <div class="col-md-3">
        @include('conversations._menu')
    </div>
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#conversation" title="{{ trans('conversations.tabs.conversation') }}" data-toggle="tooltip">
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('conversations.tabs.conversation') }}</span>
                    </a>
                </li>
                @include('cruds._tabs')
                <li class="pull-right" data-toggle="tooltip" title="{{ trans('conversations.tabs.participants') }}">
                    <a href="#members" data-toggle="ajax-modal" data-target="#entity-modal"
                       data-url="{{ route('conversations.conversation_participants.index', $model) }}">
                        <i class="fa fa-users"> {{ $model->participants->count() }}</i>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }} box-conversation" id="conversation">

                    <conversation
                        id="{{ $model->id }}"
                        api="{{ route('conversations.conversation_messages.index', $model) }}"
                        target="{{ $model->target == \App\Models\Conversation::TARGET_CHARACTERS ? 'character' : 'user'}}"
                        :targets="{{ $model->jsonParticipants() }}"
                        send="{{ route('conversations.conversation_messages.store', $model) }}"
                    >
                    </conversation>
                </div>
                @include('cruds._panes')
            </div>
        </div>
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
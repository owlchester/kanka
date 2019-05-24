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
                @include('cruds._tabs', ['relations' => false])
                <li class="pull-right" data-toggle="tooltip" title="{{ trans('conversations.tabs.participants') }}">
                    <a href="#members" data-toggle="ajax-modal" data-target="#entity-modal"
                       data-url="{{ route('conversations.conversation_participants.index', $model) }}">
                        <i class="fa fa-users"> {{ $model->participants->count() }}</i>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }} box-conversation" id="conversation">
                    <div class="box-body no-padding box-comments" id="conversation_body" data-url="{{ route('conversations.conversation_messages.index', $model) }}">
                        @include('conversations._latest', ['oldest' => null, 'newest' => null])
                    </div>
                    @can('update', $model)
                        {!! Form::open([
                            'route' => ['conversations.conversation_messages.store', $model],
                            'method'=>'POST',
                            'id' => 'conversation_send',
                        ]) !!}
                        <div class="box-footer">
                            @if ($model->participants()->count() > 0)
                            <div class="row">
                                @if ($model->target == \App\Models\Conversation::TARGET_CHARACTERS)
                                <div class="col-md-3">
                                    {!! Form::select(
                                        ($model->target == \App\Models\Conversation::TARGET_CHARACTERS ? 'character_id' : 'user_id'),
                                        $model->participantsList(),
                                        null,
                                        [
                                            'class' => 'form-control'
                                        ]
                                    ) !!}
                                </div>
                                <div class="col-md-9">
                                @else
                                {!! Form::hidden('user_id', auth()->user()->id) !!}
                                <div class="col-md-12">
                                @endif
                                    {!! Form::text(
                                        'context',
                                        null,
                                        [
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                            'maxlength' => 1000,
                                            'placeholder' => trans('conversations.messages.placeholders.message')
                                        ]
                                    ) !!}
                                </div>
                            </div>
                            @else
                                <p class="text-muted">{!! trans('conversations.hints.participants', ['icon' => '<i class="fa fa-users"></i>']) !!}</p>
                            @endif
                        </div>
                        {!! Form::hidden('conversation_id', $model->id) !!}
                        {!! Form::hidden('message', '') !!}
                        {!! Form::close() !!}
                    @endcan
                </div>
                @include('cruds._panes', ['relations' => false])
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script src="{{ mix('js/conversation.js') }}" defer></script>
@endsection
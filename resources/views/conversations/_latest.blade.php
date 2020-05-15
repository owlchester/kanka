<?php $messages = collect($model->messages()->default($oldest, $newest)->get())->reverse(); ?>
@if (count($messages) == 20)
        <div class="load-more" id="conversation_load_previous" data-url="{{ route('conversations.conversation_messages.index', [$model, 'oldest' => $messages->first()->id]) }}">
            {{ trans('conversations.messages.load_previous') }}
        </div>
@endif
@foreach ($messages as $message)
    <div class="box-comment" data-id="{{ $message->id }}">
        @if ($message->target() == \App\Models\Conversation::TARGET_USERS)
            {!! $message->user->getAvatar() !!}
        @elseif ($message->target() == \App\Models\Conversation::TARGET_CHARACTERS && !empty($message->character))
            <a class="entity-image" style="background-image: url('{{ $message->character->getImageUrl(40) }}');" title="{{ $message->character->name }}" href="{{ route('characters.show', $message->character) }}"></a>
        @endif
        <div class="comment-text">
            @can('delete', $message)
                <button class="btn btn-xs btn-danger delete-message pull-right"
                        data-toggle="modal" data-name="{{ $message->message }}"
                        data-target="#delete-confirm" data-delete-target="delete-message-{{ $message->id }}"
                        title="{{ __('crud.remove') }}">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
                {!! Form::open(['method' => 'DELETE', 'route' => ['conversations.conversation_messages.destroy', $model, $message], 'style' => 'display:inline', 'id' => 'delete-message-' . $message->id]) !!}
                {!! Form::close() !!}
            @endcan
            <span class="username">
                @if ($message->target() == \App\Models\Conversation::TARGET_USERS)
                    {{ $message->user->name }}
                @elseif ($message->target() == \App\Models\Conversation::TARGET_CHARACTERS && !empty($message->character))
                    <a href="{{ route('characters.show', $message->character) }}">{{ $message->character->name }}</a>
                @else
                    {{ trans('crud.users.unknown') }}
                @endif
            </span>
            <span class="text-muted pull-right">{{ $message->created_at->diffForHumans() }}</span>
            {{ nl2br($message->message) }}
        </div>
    </div>
@endforeach
@if(empty($messages))
    <div class="box-comment">
        <div class="comment-text">
            {{ trans('conversations.messages.empty') }}
        </div>
    </div>
@endif

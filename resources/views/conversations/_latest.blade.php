<?php $messages = collect($model->messages()->default($oldest, $newest)->get())->reverse(); ?>
@if (count($messages) == 20)
        <div class="load-more" id="conversation_load_previous" data-url="{{ route('conversations.conversation_messages.index', [$model, 'oldest' => $messages->first()->id]) }}">
            {{ trans('conversations.messages.load_previous') }}
        </div>
@endif
@foreach ($messages as $message)
    <div class="box-comment" data-id="{{ $message->id }}">
        @if ($message->target() == \App\Models\Conversation::TARGET_USERS)
            {!! $message->user->getAvatar(true) !!}
        @elseif ($message->target() == \App\Models\Conversation::TARGET_CHARACTERS)
            <a class="entity-image" style="background-image: url('{{ $message->character->getImageUrl(true) }}');" title="{{ $message->character->name }}" href="{{ route('characters.show', $message->character) }}"></a>
        @endif
        <div class="comment-text">
                <span class="username">
                    @if ($message->target() == \App\Models\Conversation::TARGET_USERS)
                        {{ $message->user->name }}
                    @elseif ($message->target() == \App\Models\Conversation::TARGET_CHARACTERS)
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
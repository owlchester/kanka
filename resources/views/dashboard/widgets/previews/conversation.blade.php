<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Conversation $conversation
 * @var \App\Models\ConversationMessage $message
 */
$conversation = $entity->child;
?>
<x-box padding="0" css="widget-conversation {{ $widget->customClass() }}">
    <x-widgets.previews.head :widget="$widget" :campaign="$campaign" :entity="$entity">
        <span class="" data-toggle="tooltip" data-title="{{ __('conversations.tabs.participants') }}">
            <x-badge>
                <x-icon class="fa-solid fa-users" />
                {{ $conversation->participants()->count() }}
            </x-badge>
        </span>
    </x-widgets.previews.head>

    <div class="widget-body p-4">
        <div class="direct-chat-messages flex flex-col gap-2">

        @foreach ($conversation->messages()->with(['character', 'user'])->orderByDesc('created_at')->take(5)->get() as $message)
            @if (empty($message->user) && empty($message->character))
                @continue
            @endif
            <div class="direct-chat-msg flex flex-3 flex-col @if ($message->isMine()) right @endif">
                <div class="direct-chat-info flex gap-2 items-center">
                    @if ($message->isMine())
                        <span class="direct-chat-timestamp text-xs grow">{{ $message->created_at->diffForHumans() }}</span>
                        <span class="direct-chat-name">
                            @if ($message->user)
                                {{ $message->user->name }}
                            @elseif ($message->character)
                                <a href="{{ $message->character->getLink() }}">{{ $message->character->name }}</a>
                            @endif
                        </span>
                    @elseif (!empty($message->user_id))
                        <span class="direct-chat-name grow">
                            {{ $message->user ? $message->user->name : null }}
                        </span>
                        <span class="direct-chat-timestamp">{{ $message->created_at->diffForHumans() }}</span>
                    @else
                        <span class="direct-chat-name grow">
                            <a href="{{ $message->character->getLink() }}">{{ $message->character->name }}</a>
                        </span>
                        <span class="direct-chat-timestamp">{{ $message->created_at->diffForHumans() }}</span>
                    @endif
                </div>
                <div class="flex gap-2 items-center">
                @if (!empty($message->user_id))
                    @if ($message->user->hasAvatar())
                    <img class="cover-background w-6 h-6 rounded-full" src="{{ $message->user->getAvatarUrl() }}" alt="{{ $message->user->name }}">
                    @endif
                @elseif (!empty($message->character_id))
                    <img class="entity-image cover-background w-6 h-6 rounded-full" src="{{ \App\Facades\Avatar::entity($message->character->entity)->fallback()->size(40)->thumbnail() }}" alt="{{ $message->character->name }}">
                @endif
                    <div class="direct-chat-text grow">
                        {{ $message->message }}
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</x-box>

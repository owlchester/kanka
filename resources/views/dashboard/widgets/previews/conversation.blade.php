<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Conversation $conversation
 * @var \App\Models\ConversationMessage $message
 */
$conversation = $entity->child;
?>
<x-box padding="0" class="widget-conversation {{ $widget->customClass() }}">
    <x-widgets.previews.head :widget="$widget" :campaign="$campaign" :entity="$entity">
        <span class="" data-toggle="tooltip" data-title="{{ __('conversations.tabs.participants') }}">
            <x-badge>
                <x-icon class="fa-regular fa-users" />
                {{ $conversation->participants_count }}
            </x-badge>
        </span>
    </x-widgets.previews.head>

    <div class="widget-body p-4">
        <div class="direct-chat-messages flex flex-col gap-2">

        @foreach ($conversation->messages as $message)
            @if (empty($message->participant))
                @continue
            @endif
            <div class="direct-chat-msg flex flex-3 flex-col @if ($message->isMine()) right @endif">
                <div class="direct-chat-info flex gap-2 items-center">
                    @if ($message->isMine())
                        <span class="direct-chat-timestamp text-xs grow">{{ $message->created_at->diffForHumans() }}</span>
                        <span class="direct-chat-name">
                            @if ($message->participant instanceof \App\Models\User)
                                {{ $message->participant->name }}
                            @elseif ($message->participant instanceof \App\Models\Entity)
                                <a href="{{ route('entities.show', [$campaign, $message->participant]) }}" class="text-link">{{ $message->participant->name }}</a>
                            @endif
                        </span>
                    @elseif ($message->participant instanceof \App\Models\User)
                        <span class="direct-chat-name grow">
                            {{ $message->participant->name }}
                        </span>
                        <span class="direct-chat-timestamp">{{ $message->created_at->diffForHumans() }}</span>
                    @else
                        <span class="direct-chat-name grow">
                            <a href="{{ route('entities.show', [$campaign, $message->participant]) }}" class="text-link">{{ $message->participant->name }}</a>
                        </span>
                        <span class="direct-chat-timestamp">{{ $message->created_at->diffForHumans() }}</span>
                    @endif
                </div>
                <div class="flex gap-2 items-center">
                @if ($message->participant instanceof \App\Models\User)
                    @if ($message->participant->hasAvatar())
                        <x-users.avatar :user="$message->participant" class="w-6 h-6" />
                    @endif
                @elseif ($message->participant instanceof \App\Models\Entity)
                    <img class="entity-image cover-background w-6 h-6 rounded-full" src="{{ \App\Facades\Avatar::entity($message->participant)->fallback()->size(40)->thumbnail() }}" alt="{{ $message->participant->name }}">
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

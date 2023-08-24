<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Conversation $conversation
 * @var \App\Models\ConversationMessage $message
 */
$conversation = $entity->child;
?>
<div class="panel panel-default widget-preview direct-chat direct-chat-primary {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
    <div
    @if ($widget->conf('entity-header') && $campaign->boosted() && $entity->header_image)
        class="panel-heading px-4 py-2 panel-heading-entity"
        style="background-image: url('{{ $entity->thumbnail(1200, 400, 'header_image') }}')"
    @elseif ($entity->child->image)
        class="panel-heading px-4 py-2 panel-heading-entity"
        style="background-image: url('{{ $entity->child->thumbnail(400) }}')"
    @elseif($campaign->superboosted() && !empty($entity->image))
        class="panel-heading px-4 py-2 panel-heading-entity"
        style="background-image: url('{{ Img::crop(1200, 400)->url($entity->image->path) }}')"
    @else
        class="panel-heading px-4 py-2"
    @endif
    >
        <h3 class="panel-title m-0">
            <a href="{{ $conversation->getLink() }}">
                @if ($conversation->is_private)
                    <i class="fa-solid fa-lock pull-right" title="{{ __('crud.is_private') }}" aria-hidden="true"></i>
                @endif

                <span class="pull-right" data-toggle="tooltip" data-title="{{ __('conversations.tabs.participants') }}">
                    <x-badge>
                        <x-icon class="fa-solid fa-users"></x-icon>
                        {{ $conversation->participants()->count() }}
                    </x-badge>
                </span>
                @if(!empty($customName))
                    {{ $customName }}
                @elseif (!empty($widget->conf('text')))
                    {{ $widget->conf('text') }}
                @else
                    {!! $entity->name !!}
                @endif

            </a>
        </h3>
    </div>
    <div class="panel-body p-4">
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
                    <img class="entity-image" src="{{ $message->user->getAvatarUrl() }}" alt="{{ $message->user->name }}">
                @elseif (!empty($message->character_id))
                    <img class="entity-image" src="{{ $message->character->thumbnail() }}" alt="{{ $message->character->name }}">
                @endif
                    <div class="direct-chat-text grow">
                        {{ $message->message }}
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>

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
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ $entity->getImageUrl(1200, 400, 'header_image') }}')"
    @elseif ($entity->child->image)
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ $entity->child->getImageUrl() }}')"
    @elseif($campaign->boosted(true) && !empty($entity->image))
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ Img::crop(1200, 400)->url($entity->image->path) }}')"
    @else
        class="panel-heading"
    @endif
    >
        <h3 class="panel-title">
            <a href="{{ $conversation->getLink() }}">
                @if ($conversation->is_private)
                    <i class="fas fa-lock pull-right" title="{{ __('crud.is_private') }}"></i>
                @endif

                <span class="pull-right" data-toggle="tooltip" title="{{ __('conversations.tabs.participants') }}">

                    <span class="label label-default"><i class="fa-solid fa-users"></i> {{ $conversation->participants()->count() }}</span>
                </span>
                @if(!empty($customName))
                    {{ $customName }}
                @elseif (!empty($widget->conf('text')))
                    {{ $widget->conf('text') }}
                @else
                    {{ $entity->name }}
                @endif

            </a>
        </h3>
    </div>
    <div class="panel-body">
        <div class="direct-chat-messages">

        @foreach ($conversation->messages()->with(['character', 'user'])->orderByDesc('created_at')->take(5)->get() as $message)
            @if (empty($message->user) && empty($message->character))
                @continue
            @endif
            <div class="direct-chat-msg @if ($message->isMine()) right @endif">
                <div class="direct-chat-info clearfix">
                    @if ($message->isMine())
                        <span class="direct-chat-name pull-right">
                            @if ($message->user)
                            {{ $message->user->name }}
                            @elseif ($message->character)
                                <a href="{{ $message->character->getLink() }}">{{ $message->character->name }}</a>
                            @endif
                        </span>
                        <span class="direct-chat-timestamp pull-left">{{ $message->created_at->diffForHumans() }}</span>
                    @elseif (!empty($message->user_id))
                        <span class="direct-chat-name pull-left">
                            {{ $message->user ? $message->user->name : null }}
                        </span>
                        <span class="direct-chat-timestamp pull-right">{{ $message->created_at->diffForHumans() }}</span>
                    @else
                        <span class="direct-chat-name pull-left">
                            <a href="{{ $message->character->getLink() }}">{{ $message->character->name }}</a>
                        </span>
                        <span class="direct-chat-timestamp pull-right">{{ $message->created_at->diffForHumans() }}</span>
                    @endif
                </div>
                @if (!empty($message->user_id))
                    <img class="direct-chat-img" src="{{ $message->user->getAvatarUrl() }}" alt="{{ $message->user->name }}">
                @elseif (!empty($message->character_id))
                    <img class="direct-chat-img" src="{{ $message->character->getImageUrl(40) }}" alt="{{ $message->character->name }}">
                @endif
                <div class="direct-chat-text">
                    {{ $message->message }}
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>

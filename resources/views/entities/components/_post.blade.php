<?php
/**
* @var \App\Models\MiscModel $model
* @var \App\Models\Entity $entity
* @var \App\Models\Post $post
*/
?>
<article class="flex flex-col gap-2 post-block post-{{ $post->id }} entity-note-{{ $post->id }} entity-note-position-{{ $post->position }} post-position-{{ $post->position }}@if (isset($post->settings['class']) && $campaign->boosted()) {{ $post->settings['class'] }}@endif " data-visibility="{{ $post->visibility_id }}" data-position="{{ $post->position }}" data-template="{{ $post->isTemplate() ? '1' : '0' }}" id="post-{{ $post->id }}">
    <div class="post-header flex gap-1 md:gap-2 items-center">
        <div class="grow flex gap-2 items-center cursor-pointer element-toggle {{ $post->collapsed() ? "animate-collapsed" : null }}" data-animate="collapse" data-target="#post-body-{{ $post->id }}">
            <x-icon class="fa-solid fa-chevron-up icon-show"></x-icon>
            <x-icon class="fa-solid fa-chevron-down icon-hide"></x-icon>
            <h3 class="post-title grow {{ $post->collapsed() ? "collapsed" : null }}"  >
                {{ $post->name  }}
                @if (app()->isLocal())
                    <sup class="text-xs">({{ $post->position }})</sup>
                @endif
            </h3>
        </div>
        <div class="flex-none flex gap-1 items-center">
            @if (auth()->check() && auth()->user()->can('post', [$entity->child, 'edit', $post]))
            <span id="visibility-icon-{{ $post->id }}" class="btn2 btn-ghost btn-sm" data-toggle="dialog" data-url="{{ route('posts.edit.visibility', [$campaign, $entity->id, $post->id]) }}" data-target="primary-dialog">
                @include('icons.visibility', ['icon' => $post->visibilityIcon()])
            </span>
                <div class="dropdown">
                    <a role="button" class="btn2 btn-ghost btn-sm" data-dropdown aria-expanded="false" data-placement="right" data-tree="escape">
                        <x-icon class="fa-solid fa-ellipsis-v"></x-icon>
                        <span class="sr-only">{{__('crud.actions.actions') }}</span>
                    </a>
                    <div class="dropdown-menu hidden" role="menu">
                        @include('entities.pages.posts._actions')
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="bg-box rounded post entity-note">
        <div class="entity-content overflow-hidden @if ($post->collapsed()) hidden @endif" id="post-body-{{ $post->id }}">
            <div class="flex flex-col gap-2 p-4">
                <div class="post-details entity-note-details">
                    @if ($post->location)
                    <span class="entity-note-detail-element entity-note-location post-detail-element post-location">
                        <x-icon entity="location" />
                        <x-entity-link :entity="$post->location->entity" :campaign="$campaign" />
                    </span>
                    @endif
                </div>
                <div class="entity-note-body post-body  overflow-x-auto">
                    {!! $post->parsedEntry() !!}
                </div>

                <div class="post-footer entity-note-footer text-right text-muted text-xs ">

                @can('update', $model)
                <a href="{{ route('entities.posts.logs', [$campaign, $model->entity, $post]) }}" data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('entities.posts.logs', [$campaign, $model->entity, $post]) }}" title="{{ __('crud.history.view') }}" class="print-none">
                    <x-icon class="fa-solid fa-history" />
                </a>
                @endcan

                    <span class="post-footer-element post-created entity-note-footer-element entity-note-created" data-title="{{ __('entities/notes.footer.created', [
        'user' => $post->created_by ? e(\App\Facades\UserCache::name($post->created_by)) : __('crud.users.unknown'),
        'date' => $post->created_at->isoFormat('MMMM Do Y, hh:mm a')]) }}" data-toggle="tooltip">
                        {{ $post->created_at->isoFormat('MMMM Do, Y') }}
                    </span>
                        @if ($post->updated_at->greaterThan($post->created_at))
                            <span class="post-footer-element post-updated entity-note-footer-element entity-note-updated" data-title="{{ __('entities/notes.footer.updated', [
        'user' => $post->updated_by ? e(\App\Facades\UserCache::name($post->updated_by)) : __('crud.users.unknown'),
        'date' => $post->updated_at->isoFormat('MMMM Do Y, hh:mm a')]) }}" data-toggle="tooltip">
                        {{ $post->updated_at->isoFormat('MMMM Do, Y') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</article>

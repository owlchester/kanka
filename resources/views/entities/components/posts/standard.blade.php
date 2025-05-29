<?php
/**
* @var \App\Models\Entity $entity
* @var \App\Models\Post $post
*/

/** @var \App\Models\Tag[] $entityTags */
$entityTags = $post->visibleTags;
?>
<article class="flex flex-col gap-2 post-block post-{{ $post->id }} entity-note-{{ $post->id }} entity-note-position-{{ $post->position }} post-position-{{ $post->position }}@if (isset($post->settings['class']) && $campaign->boosted()) {{ $post->settings['class'] }}@endif @foreach ($entityTags as $tag) tag-{{ $tag->slug }} @endforeach" data-visibility="{{ $post->visibility_id }}" data-position="{{ $post->position }}" data-template="{{ $post->isTemplate() ? '1' : '0' }}" id="post-{{ $post->id }}" data-word-count="{{ $post->words }}">
    <div class="post-header flex gap-1 md:gap-2 items-center justify-between">
        <div class="flex gap-2 items-center cursor-pointer element-toggle group {{ $post->collapsed() ? "animate-collapsed" : null }}" data-animate="collapse" data-target="#post-body-{{ $post->id }}">
            <x-icon class="fa-regular fa-chevron-up icon-show transition-transform duration-200 group-hover:-translate-y-0.5" />
            <x-icon class="fa-regular fa-chevron-down icon-hide transition-transform duration-200 group-hover:translate-y-0.5" />
            <h3 class="post-title {{ $post->collapsed() ? "collapsed" : null }}"  >
                {!! $post->name !!}
                @if (config('app.debug'))
                    <sup class="text-xs">({{ $post->position }})</sup>
                @endif
            </h3>
        </div>
        <div class="flex gap-1 items-center">
            @can('post', [$entity, 'edit', $post])
                @can('visibility', $post)
                    <span id="visibility-icon-{{ $post->id }}" class="btn2 btn-ghost btn-sm" data-toggle="dialog" data-url="{{ route('posts.edit.visibility', [$campaign, $entity->id, $post->id]) }}" data-target="primary-dialog">
                    @include('icons.visibility', ['icon' => $post->visibilityIcon()])
                </span>
                @else
                    @include('icons.visibility', ['icon' => $post->visibilityIcon()])
                @endif
                <div class="dropdown">
                    <a role="button" class="btn2 btn-ghost btn-sm" data-dropdown aria-expanded="false" data-placement="right" data-tree="escape">
                        <x-icon class="fa-regular fa-ellipsis-v" />
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
                <x-posts.tags :post="$post" :campaign="$campaign"></x-posts.tags>

                @if ($post->location)
                <div class="post-details entity-note-details">
                    <span class="entity-note-detail-element entity-note-location post-detail-element post-location">
                        <x-icon entity="location" />
                        <x-entity-link :entity="$post->location->entity" :campaign="$campaign" />
                    </span>
                </div>
                @endif
                <div class="entity-note-body post-body overflow-x-auto">
                    {!! $post->parsedEntry() !!}
                </div>

                <div class="post-footer entity-note-footer text-right text-muted text-xs ">

                @can('update', $entity)
                <a href="{{ route('entities.posts.logs', [$campaign, $entity, $post]) }}" title="{{ __('crud.history.view') }}" class="print-none">
                    <x-icon class="fa-regular fa-history" />
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
                <x-word-count :count="$post->words" />
            </div>
        </div>
    </div>
</article>

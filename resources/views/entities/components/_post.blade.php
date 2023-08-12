<?php
/**
* @var \App\Models\MiscModel $model
* @var \App\Models\Entity $entity
* @var \App\Models\Post $post
* @var \Illuminate\Database\Eloquent\Collection $pinnedNotes
*/
?>
<div class="post-{{ $post->id }} entity-note-{{ $post->id }} entity-note-position-{{ $post->position }} post-position-{{ $post->position }}@if (isset($post->settings['class']) && $campaign->boosted()) {{ $post->settings['class'] }}@endif" data-visibility="{{ $post->visibility_id }}" data-position="{{ $post->position }}">
    <div class="box box-solid post entity-note" id="post-{{ $post->id }}">
        <div class="box-header with-border">
            <h3 class="box-title cursor-pointer element-toggle {{ $post->collapsed() ? "collapsed" : null }}" data-toggle="collapse" data-target="#post-body-{{ $post->id }}" data-short="post-toggle-{{ $post->id }}" >
                <x-icon class="fa-solid fa-chevron-up icon-show"></x-icon>
                <x-icon class="fa-solid fa-chevron-down icon-hide"></x-icon>
                {{ $post->name  }}
                @if (app()->environment('local'))
                    <sup>({{ $post->position }})</sup>
                @endif
            </h3>
            <div class="box-tools">
                @if (auth()->check())
                    {!! $post->visibilityIcon('btn-box-tool') !!}

                    <a class="dropdown-toggle btn btn-box-tool" data-toggle="dropdown" aria-expanded="false" data-placement="right" data-tree="escape">
                        <x-icon class="fa-solid fa-ellipsis-v"></x-icon>
                        <span class="sr-only">{{__('crud.actions.actions') }}'</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        @can('post', [$model, 'edit', $post])
                        <li>
                            <a href="{{ route('entities.posts.edit', [$campaign, 'entity' => $entity, 'post' => $post, 'from' => 'main']) }}" title="{{ __('crud.edit') }}">
                                <x-icon class="edit"></x-icon>
                                {{ __('crud.edit') }}
                            </a>
                        </li>
                        @endcan
                        @if (!isset($more))
                        <li>
                            <a href="#" title="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $post->id }}]" data-toggle="tooltip"
                               data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $post->id }}]" data-toast="{{ __('entities/notes.copy_mention.success') }}">
                                <x-icon class="fa-solid fa-link"></x-icon>
                                {{ __('entities/notes.copy_mention.copy') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" title="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $post->id }}|{{ $post->name }}]" data-toggle="tooltip"
                               data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $post->id }}|{{ $post->name }}]" data-toast="{{ __('entities/notes.copy_mention.success') }}">
                                <x-icon class="fa-solid fa-link"></x-icon>
                                {{ __('entities/notes.copy_mention.copy_with_name') }}
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->isAdmin())
                        <li>
                            <a href="{{ route('posts.move', [$campaign, 'entity' => $entity, 'post' => $post, 'from' => 'main']) }}" title="{{ __('crud.edit') }}">
                                <x-icon class="fa-solid fa-arrows-left-right"></x-icon> {{ __('entities/notes.move.move') }}
                            </a>
                        </li>
                        @endif
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('entities.story.reorder', [$campaign, 'entity' => $entity]) }}" title="{{ __('entities/story.reorder.icon_tooltip') }}">
                                <x-icon class="fa-solid fa-arrows-v"></x-icon>
                                {{ __('entities/story.reorder.icon_tooltip') }}
                            </a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
        <div class="entity-content box-body collapse !visible @if(!$post->collapsed()) in @endif" id="post-body-{{ $post->id }}">
            <div class="post-details mb-2 entity-note-details">

                @if ($post->location)
                <span class="entity-note-detail-element entity-note-location post-detail-element post-location">
                <x-icon :class="\App\Facades\Module::icon(config('entities.ids.location'), 'ra ra-tower')"></x-icon>
                    {!! $post->location->tooltipedLink() !!}
                </span>
                @endif
            </div>
            <div class="entity-note-body post-body">
                {!! $post->entry() !!}
            </div>


            <div class="post-footer entity-note-footer text-right text-muted text-xs ">
                <span class="post-footer-element post-created entity-note-footer-element entity-note-created" title="{{ __('entities/notes.footer.created', [
    'user' => $post->created_by ? e(\App\Facades\UserCache::name($post->created_by)) : __('crud.users.unknown'),
    'date' => $post->created_at->isoFormat('MMMM Do Y, hh:mm a')]) }}" data-toggle="tooltip">
                    {{ $post->created_at->isoFormat('MMMM Do, Y') }}
                </span>
                    @if ($post->updated_at->greaterThan($post->created_at))
                        <span class="post-footer-element post-updated entity-note-footer-element entity-note-updated" title="{{ __('entities/notes.footer.updated', [
    'user' => $post->updated_by ? e(\App\Facades\UserCache::name($post->updated_by)) : __('crud.users.unknown'),
    'date' => $post->updated_at->isoFormat('MMMM Do Y, hh:mm a')]) }}" data-toggle="tooltip">
                    {{ $post->updated_at->isoFormat('MMMM Do, Y') }}
                </span>
                @endif
            </div>
        </div>
    </div>
</div>

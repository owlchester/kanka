<?php
/**
* @var \App\Models\MiscModel $model
* @var \App\Models\Entity $entity
* @var \App\Models\Post $post
* @var \Illuminate\Database\Eloquent\Collection $pinnedNotes
*/
?>
<div class="entity-note-{{ $post->id }} entity-note-position-{{ $post->position }}" data-visibility="{{ $post->visibility_id }}" data-position="{{ $post->position }}">
    <div class="box box-solid entity-note" id="post-{{ $post->id }}">
        <div class="box-header with-border">
            <h3 class="box-title cursor entity-note-toggle" data-toggle="collapse" data-target="#entity-note-body-{{ $post->id }}" data-short="entity-note-toggle-{{ $post->id }}">
                <i class="fa-solid fa-chevron-up" id="entity-note-toggle-{{ $post->id }}-show" @if ($post->collapsed()) style="display: none;" @endif></i>
                <i class="fa-solid fa-chevron-down" id="entity-note-toggle-{{ $post->id }}-hide" @if (!$post->collapsed()) style="display: none;" @endif></i>
                {{ $post->name  }}
                @if (app()->environment('local'))
                    <sup>({{ $post->position }})</sup>
                @endif
            </h3>
            <div class="box-tools">
                @if (auth()->check())
                    {!! $post->visibilityIcon('btn-box-tool') !!}

                    <a class="dropdown-toggle btn btn-box-tool" data-toggle="dropdown" aria-expanded="false" data-placement="right" data-tree="escape">
                        <i class="fa-solid fa-ellipsis-v"></i>
                        <span class="sr-only">{{__('crud.actions.actions') }}'</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        @can('post', [$model, 'edit', $post])
                        <li>
                            <a href="{{ route('entities.posts.edit', ['entity' => $entity, 'post' => $post, 'from' => 'main']) }}" title="{{ __('crud.edit') }}">
                                <i class="fa-solid fa-edit"></i> {{ __('crud.edit') }}
                            </a>
                        </li>
                        @endcan
                        <li>
                            <a href="#" title="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $post->id }}]" data-toggle="tooltip"
                               data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $post->id }}]" data-toast="{{ __('entities/notes.copy_mention.success') }}">
                                <i class="fa-solid fa-link"></i> {{ __('entities/notes.copy_mention.copy') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" title="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $post->id }}|{{ $post->name }}]" data-toggle="tooltip"
                               data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $post->id }}|{{ $post->name }}]" data-toast="{{ __('entities/notes.copy_mention.success') }}">
                                <i class="fa-solid fa-link"></i> {{ __('entities/notes.copy_mention.copy_with_name') }}
                            </a>
                        </li>
                        @if(auth()->user()->isAdmin())
                        <li>
                            <a href="{{ route('posts.move', ['entity' => $entity, 'post' => $post, 'from' => 'main']) }}" title="{{ __('crud.edit') }}">
                                <i class="fa-solid fa-arrows-left-right"></i> {{ __('entities/notes.move.move') }}
                            </a>
                        </li>
                        @endif
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('entities.story.reorder', ['entity' => $entity]) }}" title="{{ __('entities/story.reorder.icon_tooltip') }}">
                                <i class="fa-solid fa-arrows-v"></i> {{ __('entities/story.reorder.icon_tooltip') }}
                            </a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
        <div class="entity-content box-body collapse @if(!$post->collapsed()) in @endif" id="entity-note-body-{{ $post->id }}">
            <div class="entity-note-details">

                @if ($post->location)
                <span class="entity-note-detail-element entity-note-location">
                    <i class="ra ra-tower"></i> {!! $post->location->tooltipedLink() !!}
                </span>
                @endif
            </div>
            <div class="entity-note-body">
                {!! $post->entry() !!}
            </div>


            <div class="entity-note-footer text-right text-muted">
            <span class="entity-note-footer-element entity-note-created" title="{{ __('entities/notes.footer.created', [
'user' => $post->created_by ? e(\App\Facades\UserCache::name($post->created_by)) : __('crud.users.unknown'),
'date' => $post->created_at->isoFormat('MMMM Do Y, hh:mm a')]) }}" data-toggle="tooltip">
                {{ $post->created_at->isoFormat('MMMM Do, Y') }}
            </span>
                @if ($post->updated_at->greaterThan($post->created_at))
                    <span class="entity-note-footer-element entity-note-updated" title="{{ __('entities/notes.footer.updated', [
'user' => $post->updated_by ? e(\App\Facades\UserCache::name($post->updated_by)) : __('crud.users.unknown'),
'date' => $post->updated_at->isoFormat('MMMM Do Y, hh:mm a')]) }}" data-toggle="tooltip">
                {{ $post->updated_at->isoFormat('MMMM Do, Y') }}
            </span>
                @endif
            </div>
        </div>
    </div>
</div>

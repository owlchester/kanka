<?php
/**
* @var \App\Models\MiscModel $model
* @var \App\Models\Entity $entity
* @var \App\Models\Post $post
* @var \Illuminate\Database\Eloquent\Collection $pinnedNotes
*/
?>
<div class="post-{{ $post->id }} entity-note-{{ $post->id }} entity-note-position-{{ $post->position }} post-position-{{ $post->position }}@if (isset($post->settings['class']) && $campaign->boosted()) {{ $post->settings['class'] }}@endif" data-visibility="{{ $post->visibility_id }}" data-position="{{ $post->position }}">
    <div class="box box-solid post entity-note" id="post-{{ $post->id }}" @if($post->layout) style="background-color:transparent" @endif>
        <div class="box-header @if(!$post->layout) with-border @endif">
            <h3 class="box-title @if (!$post->layout) cursor-pointer element-toggle {{ $post->collapsed() ? "collapsed" : null }}" data-toggle="collapse" data-target="#post-body-{{ $post->id }}" data-short="post-toggle-{{ $post->id }} @endif" >
                @if (!$post->layout)
                    <x-icon class="fa-solid fa-chevron-up icon-show"></x-icon>
                    <x-icon class="fa-solid fa-chevron-down icon-hide"></x-icon>
                @endif
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
                            <a href="{{ route('entities.posts.edit', ['entity' => $entity, 'post' => $post, 'from' => 'main']) }}" title="{{ __('crud.edit') }}">
                                <x-icon class="edit"></x-icon>
                                {{ __('crud.edit') }}
                            </a>
                        </li>
                        @endcan
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
                        @if(auth()->user()->isAdmin())
                        <li>
                            <a href="{{ route('posts.move', ['entity' => $entity, 'post' => $post, 'from' => 'main']) }}" title="{{ __('crud.edit') }}">
                                <x-icon class="fa-solid fa-arrows-left-right"></x-icon> {{ __('entities/notes.move.move') }}
                            </a>
                        </li>
                        @endif
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('entities.story.reorder', ['entity' => $entity]) }}" title="{{ __('entities/story.reorder.icon_tooltip') }}">
                                <x-icon class="fa-solid fa-arrows-v"></x-icon>
                                {{ __('entities/story.reorder.icon_tooltip') }}
                            </a>
                        </li>
                    </ul>
                @endif
                @if($post->layout?->code == 'inventory')
                    @php 
                        $inventory = $entity
                            ->inventories()
                            ->with(['entity', 'item', 'item.entity'])
                            ->get()
                            ->sortBy(function ($model, $key) {
                                return !empty($model->position) ? $model->position : 'zzzz' . $model->itemName();
                            });
                    @endphp
                    @include('entities.pages.inventory._buttons', ['inventory' => $inventory, 'isPost' => true, 'entity' => $entity, 'ajax' => null])
                @elseif ($post->layout?->code == 'attributes')
                    @include('entities.pages.attributes._buttons', ['isPost' => true])
                @elseif ($post->layout?->code == 'abilities')
                    @include('entities.pages.abilities._buttons', ['isPost' => true])
                @elseif ($post->layout?->code == 'assets')
                    @include('entities.pages.assets._buttons', ['assets' => $entity->assets, 'isPost' => true])
                @elseif ($post->layout?->code == 'connection_map')
                    @include('entities.pages.relations._buttons', ['option' => null, 'isPost' => true, 'mode' => 'map'])
                @endif
            </div>
        </div>
        <div class="entity-content box-body collapse !visible @if(!$post->collapsed()) in @endif" id="post-body-{{ $post->id }}">
            <div class="post-details mb-2 entity-note-details">
                @if ($post->location)
                <span class="entity-note-detail-element entity-note-location post-detail-element post-location">
                    <x-icon class="ra ra-tower"></x-icon>
                    {!! $post->location->tooltipedLink() !!}
                </span>
                @endif
            </div>
            @if($post->layout?->code == 'inventory')
                @php 
                    $inventory = $entity
                        ->inventories()
                        ->with(['entity', 'item', 'item.entity'])
                        ->get()
                        ->sortBy(function ($model, $key) {
                            return !empty($model->position) ? $model->position : 'zzzz' . $model->itemName();
                        });
                @endphp
                @include('entities.pages.inventory._table', ['inventory' => $inventory, 'isPost' => true, 'entity' => $entity, 'ajax' => null])
            @elseif ($post->layout?->code == 'attributes')
                <x-box css="box-entity-attributes">
                    @include('entities.pages.attributes.render', ['isPost' => true])
                </x-box>
                <input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', $entity) }}" />
            @elseif ($post->layout?->code == 'abilities')
                @php
                $translations = [
                    'all' => __('crud.visibilities.all'),
                    'members' => __('crud.visibilities.members'),
                    'admin-self' => __('crud.visibilities.admin-self'),
                    'admin' => __('crud.visibilities.admin'),
                    'self' => __('crud.visibilities.self'),
                    'update' => __('crud.update'),
                    'remove' => __('crud.remove'),
                ];
                $translations = json_encode($translations);
                @endphp
                @include('entities.pages.abilities._abilities', ['isPost' => true])
            @elseif ($post->layout?->code == 'assets')
                @include('entities.pages.assets._asset', ['assets' => $entity->assets, 'isPost' => true])
            @elseif ($post->layout?->code == 'connection_map')
                @include('entities.pages.relations._map', ['option' => null, 'isPost' => true, 'mode' => 'map'])
            @else
                <div class="entity-note-body post-body">
                    {!! $post->entry() !!}
                </div>
            @endif

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

@section('styles')
    @parent
    @vite('resources/sass/abilities.scss')
    @vite('resources/sass/relations.scss')
@endsection

@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
    @vite('resources/js/abilities.js')
    @vite('resources/js/relations.js')
@endsection

@section('modals')
    @parent
    <div class="modal fade" id="live-attribute-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-base-100"></div>
        </div>
    </div>
@endsection

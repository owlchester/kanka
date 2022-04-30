<?php
/**
* @var \App\Models\MiscModel $model
* @var \App\Models\Entity $entity
* @var \App\Models\EntityNote $note
* @var \Illuminate\Database\Eloquent\Collection $pinnedNotes
*/
?>
<div class="entity-note-{{ $note->id }} entity-note-position-{{ $note->position }}" data-visibility="{{ $note->visibility }}">
    <div class="box box-solid entity-note" id="post-{{ $note->id }}">
        <div class="box-header with-border">
            <h3 class="box-title cursor entity-note-toggle" data-toggle="collapse" data-target="#entity-note-body-{{ $note->id }}" data-short="entity-note-toggle-{{ $note->id }}">
                <i class="fa-solid fa-chevron-up" id="entity-note-toggle-{{ $note->id }}-show" @if ($note->collapsed()) style="display: none;" @endif></i>
                <i class="fa-solid fa-chevron-down" id="entity-note-toggle-{{ $note->id }}-hide" @if (!$note->collapsed()) style="display: none;" @endif></i>
                {{ $note->name  }}
                @if (app()->environment('local'))
                    ({{ $note->position }})
                @endif
            </h3>
            <div class="box-tools">
                @if (auth()->check())
                    @include('cruds.partials.visibility', ['model' => $note, 'toolbox' => true])

                    <a class="dropdown-toggle btn btn-box-tool" data-toggle="dropdown" aria-expanded="false" data-placement="right" data-tree="escape">
                        <i class="fas fa-ellipsis-v"></i>
                        <span class="sr-only">{{__('crud.actions.actions') }}'</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        @can('entity-note', [$model, 'edit', $note])
                        <li>
                            <a href="{{ route('entities.entity_notes.edit', ['entity' => $entity, 'entity_note' => $note, 'from' => 'main']) }}" title="{{ __('crud.edit') }}">
                                <i class="fa-solid fa-edit"></i> {{ __('crud.edit') }}
                            </a>
                        </li>
                        @endcan
                        <li>
                            <a href="#" title="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $note->id }}]" data-toggle="tooltip"
                               data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $note->id }}]" data-toast="{{ __('entities/notes.copy_mention.success') }}">
                                <i class="fa-solid fa-link"></i> {{ __('entities/notes.copy_mention.copy') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" title="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $note->id }}]|{{ $model->name }}" data-toggle="tooltip"
                               data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|anchor:post-{{ $note->id }}|{{ $model->name }}]" data-toast="{{ __('entities/notes.copy_mention.success') }}">
                                <i class="fa-solid fa-link"></i> {{ __('entities/notes.copy_mention.copy_with_name') }}
                            </a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
        <div class="entity-content box-body collapse @if(!$note->collapsed()) in @endif" id="entity-note-body-{{ $note->id }}">
            <div class="entity-note-details">

                @if ($note->location)
                <span class="entity-note-detail-element entity-note-location">
                    <i class="ra ra-tower"></i> {!! $note->location->tooltipedLink() !!}
                </span>
                @endif
            </div>
            <div class="entity-note-body">
                {!! $note->entry() !!}
            </div>


            <div class="entity-note-footer text-right text-muted">
            <span class="entity-note-footer-element entity-note-created" title="{{ __('entities/notes.footer.created', [
'user' => $note->created_by ? e(\App\Facades\UserCache::name($note->created_by)) : __('crud.users.unknown'),
'date' => $note->created_at->isoFormat('MMMM Do Y, hh:mm a')]) }}" data-toggle="tooltip">
                {{ $note->created_at->isoFormat('MMMM Do, Y') }}
            </span>
                @if ($note->updated_at->greaterThan($note->created_at))
                    <span class="entity-note-footer-element entity-note-updated" title="{{ __('entities/notes.footer.updated', [
'user' => $note->updated_by ? e(\App\Facades\UserCache::name($note->updated_by)) : __('crud.users.unknown'),
'date' => $note->updated_at->isoFormat('MMMM Do Y, hh:mm a')]) }}" data-toggle="tooltip">
                {{ $note->updated_at->isoFormat('MMMM Do, Y') }}
            </span>
                @endif
            </div>
        </div>
    </div>
</div>

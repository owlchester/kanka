@php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\EntityNote $note
 */
$pinnedNotes = $model->entity->notes()->ordered()->get();
@endphp
<div class="entity-notes">
    @foreach ($pinnedNotes as $note)
        <div class="entity-note-{{ $note->id }} entity-note-position-{{ $note->position }}">
            <div class="box box-solid entity-note" id="entity-note-{{ $note->id }}">
                <div class="box-header with-border">
                    <h3 class="box-title cursor entity-note-toggle" data-toggle="collapse" data-target="#entity-note-body-{{ $note->id }}" data-short="entity-note-toggle-{{ $note->id }}">
                        <i class="fa fa-chevron-up" id="entity-note-toggle-{{ $note->id }}-show" @if($note->collapsed()) style="display: none;" @endif></i>
                        <i class="fa fa-chevron-down" id="entity-note-toggle-{{ $note->id }}-hide" @if(!$note->collapsed()) style="display: none;" @endif></i>
                        {{ $note->name  }}
                    </h3>
                    <div class="box-tools">
                        @if (auth()->check())
                            @include('cruds.partials.visibility', ['model' => $note])

                            @can('entity-note', [$model, 'edit', $note])
                                <a href="{{ route('entities.entity_notes.edit', ['entity' => $model->entity, 'entity_note' => $note, 'from' => 'main']) }}" class="btn btn-default" title="{{ __('crud.edit') }}" role="button">
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan
                        @endif
                    </div>
                </div>
                <div class="box-body collapse @if(!$note->collapsed()) in @endif" id="entity-note-body-{{ $note->id }}">
                    {!! $note->entry() !!}
                </div>
            </div>
        </div>
    @endforeach
</div>

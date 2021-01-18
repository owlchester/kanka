@php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\EntityNote $note
 */
$pinnedNotes = $model->entity->notes()->pinned()->get();
$remainingNotes = $pinnedNotes->count();
$displayedNotes = 0;
@endphp
<div class="row entity-notes">
    @foreach ($pinnedNotes as $note)
        @php $remainingNotes--; @endphp
        <div class="col-sm-12 col-md-12 col-lg-{{ $remainingNotes == 0 && $displayedNotes % 2 == 0 ? 12 : 12 }}">
            <div class="box box-solid entity-note entity-note-{{ $note->id }}" id="entity-note-{{ $note->id }}">
                <div class="box-header with-border">
                    <h3 class="box-title cursor entity-note-toggle" data-toggle="collapse" data-target="#entity-note-body-{{ $note->id }}" data-short="entity-note-toggle-{{ $note->id }}">
                        <i class="fa fa-chevron-up" id="entity-note-toggle-{{ $note->id }}-show"></i>
                        <i class="fa fa-chevron-down" id="entity-note-toggle-{{ $note->id }}-hide" style="display: none;"></i>
                        {{ $note->name  }}
                    </h3>
                    <div class="box-tools">
                        @if (auth()->check())
                            @include('cruds.partials.visibility', ['model' => $note])

                            @can('entity-note', [$model, 'edit', $note])
                                <a href="{{ route('entities.entity_notes.edit', ['entity' => $model->entity, 'entity_note' => $note, 'from' => 'main']) }}" class="" title="{{ __('crud.edit') }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan
                            @can('entity-note', [$model, 'delete'])
                                <a href="#" class="text-danger delete-confirm" data-toggle="modal" data-name="{{ $note->name }}"
                                        data-target="#delete-confirm" data-delete-target="delete-form-{{ $note->id }}"
                                        title="{{ __('crud.remove') }}">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            @endcan

                        @endif
                    </div>
                </div>
                <div class="box-body collapse in" id="entity-note-body-{{ $note->id }}">
                    {!! $note->entry() !!}
                </div>
            </div>
        </div>
        @php $displayedNotes++; @endphp
    @endforeach
</div>

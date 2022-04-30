@php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 * @var \App\Models\EntityNote $note
 * @var \Illuminate\Database\Eloquent\Collection $pinnedNotes
 */
if (empty($entity)) {
    $entity = $model->entity;
}
$wrapper = false;
$entryShown = false;
if (!isset($pinnedNotes)) {
    $pinnedNotes = $entity->notes()->with(['permissions', 'location'])->ordered()->paginate(15);
    $wrapper = true;
}

$first = $pinnedNotes->first();
@endphp

@if(isset($withEntry) && ($pinnedNotes->count() === 0 || (!empty($first) && $first->position >= 0)))
    @include('entities.components.entry')
    @php $entryShown = true; @endphp
@endif


@if($wrapper)
<div class="entity-notes">
@endif
    @foreach ($pinnedNotes as $note)
        @if (isset($withEntry) && !$entryShown && $note->position >= 0)
            @include('entities.components.entry')
            @php $entryShown = true @endphp
        @endif

        @include('entities.components._note')
    @endforeach


    @if (isset($withEntry) && !$entryShown)
        @include('entities.components.entry')
        @php $entryShown = true @endphp
    @endif

    @if ($pinnedNotes->currentPage() < $pinnedNotes->lastPage())
        <div class="text-center">
            <a href="#" class="btn btn-default btn-sm margin-bottom story-load-more" data-url="{{ route('entities.story.load-more', [$entity, 'page' => $pinnedNotes->currentPage() + 1]) }}">
                <i class="fas fa-refresh"></i> {{ __('entities/story.actions.load_more') }}
            </a>

            <i class="fa-solid fa-spinner fa-spin fa-2x" id="story-more-spinner" style="display: none"></i>
        </div>
    @endif

@if($wrapper)
</div>
@endif

@if (!request()->ajax() && $entity && !$entity->isType([config('entities.ids.map'), config('entities.ids.timeline'), config('entities.ids.calendar')]))
@can('entity-note', [$model, 'add'])
    <div class="margin-bottom text-center row-add-note-button">
        <a href="{{ route('entities.entity_notes.create', $entity) }}" class="btn btn-warning btn-sm"
           data-toggle="tooltip" title="{{ __('crud.tooltips.new_post') }}">
            <i class="fa-solid fa-plus"></i> {{ __('crud.actions.new_post') }}
        </a>
    </div>
@endcan
@endif

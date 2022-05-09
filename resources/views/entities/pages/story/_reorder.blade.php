<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\EntityNote[]|\Illuminate\Support\Collection $notes
 * @var \App\Models\EntityNote $first
 */
$hasEntry = false;

$notes = $entity->notes()->ordered()->get();

$startWithStory = false;
$firstNote = $notes->first();
// If the first note has a positive position, it's after the entry field
if ($firstNote && $firstNote->position >= 0) {
    $startWithStory = true;
    $hasEntry = true;
}
?>
{!! Form::open([
    'route' => ['entities.story.reorder-save', $entity],
    'method' => 'POST',
]) !!}
<div class="box box-solid box-entity-story-reorder">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('entities/story.reorder.panel_title') }}
        </h3>
    </div>
    <div class="box-body">
        <div class="element-live-reorder">
            @includeWhen($startWithStory, 'entities.pages.story.reorder._story')

            @foreach($notes as $note)
                @if (!$hasEntry && $note->position >= 0)
                    @php $hasEntry = true @endphp
                    @include('entities.pages.story.reorder._story')
                @endif

                <div class="element" data-id="{{ $note->id }}">
                    {!! Form::hidden('posts[' . $note->id . '][id]', $note->id) !!}
                    <div class="dragger">
                        <span class="fa-solid fa-ellipsis-v visible-md visible-lg"></span>
                        <div class="visible-xs visible-sm">
                            <span class="fa-solid fa-arrow-up"></span><br />
                            <span class="fa-solid fa-arrow-down"></span>
                        </div>
                    </div>
                    <div class="name">
                        {!! $note->name !!}
                    </div>
                    <div class="state">
                        <select name="posts[{{ $note->id }}][collapsed]" class="form-control">
                            <option value="0">{{ __('entities/notes.states.expanded') }}</option>
                            <option value="1" @if ($note->collapsed()) selected="selected" @endif>{{ __('entities/notes.states.collapsed') }}</option>
                        </select>
                    </div>

                    <div class="icons">
@php
    $options = [];
    $options['all'] = __('crud.visibilities.all');

    if (auth()->user()->isAdmin()) {
        $options['admin'] = __('crud.visibilities.admin');
        $options['members'] = __('crud.visibilities.members');
    }
    if ($note->created_by == auth()->user()->id) {
        $options['self'] = __('crud.visibilities.self');
        $options['admin-self'] = __('crud.visibilities.admin-self');
    }

    // If it's a visibility self & admin and we're not the creator, we can't change this
    if ($note->visibility === \App\Models\Visibility::VISIBILITY_ADMIN_SELF_STR && $note->created_by !== auth()->user()->id) {
        $options = ['admin-self' => __('crud.visibilities.admin-self')];
    }
@endphp
                        <select name="posts[{{ $note->id }}][visibility]" class="form-control">
                            @foreach ($options as $key => $value)
                                <option value="{{ $key }}" @if ($key == $note->visibility) selected="selected" @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
            @includeWhen(!$hasEntry, 'entities.pages.story.reorder._story')
        </div>
    </div>
    <div class="box-footer">
        <button class="btn btn-primary btn-block">
            {{ __('entities/story.reorder.save') }}
        </button>
    </div>
</div>

{!! Form::close() !!}

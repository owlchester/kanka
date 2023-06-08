<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Post[]|\Illuminate\Support\Collection $posts
 * @var \App\Models\Post $first
 */
$hasEntry = false;

$posts = $entity->posts()->ordered()->get();

$startWithStory = false;
$firstPost = $posts->first();
// If the first note has a positive position, it's after the entry field
if ($firstPost && $firstPost->position >= 0) {
    $startWithStory = true;
    $hasEntry = true;
}
?>
{!! Form::open([
    'route' => ['entities.story.reorder-save', $entity],
    'method' => 'POST',
]) !!}
<div class="box-entity-story-reorder max-w-4xl">
    <div class="element-live-reorder sortable-elements">
        @includeWhen($startWithStory, 'entities.pages.story.reorder._story')

        @foreach($posts as $note)
            @if (!$hasEntry && $note->position >= 0)
                @php $hasEntry = true @endphp
                @include('entities.pages.story.reorder._story')
            @endif

            <div class="element" data-id="{{ $note->id }}">
                {!! Form::hidden('posts[' . $note->id . '][id]', $note->id) !!}
                <div class="dragger pr-3">
                    <span class="fa-solid fa-ellipsis-v"></span>
                </div>
                <div class="name overflow-hidden flex-grow">
                    {!! $note->name !!}
                </div>
                <div class="px-2 self-end">
                    <select name="posts[{{ $note->id }}][collapsed]" class="form-control">
                        <option value="0">{{ __('entities/notes.states.expanded') }}</option>
                        <option value="1" @if ($note->collapsed()) selected="selected" @endif>{{ __('entities/notes.states.collapsed') }}</option>
                    </select>
                </div>

                <div class="self-end">
@php
$options = [];
$options[\App\Models\Visibility::VISIBILITY_ALL] = __('crud.visibilities.all');

if (auth()->user()->isAdmin()) {
    $options[\App\Models\Visibility::VISIBILITY_ADMIN] = __('crud.visibilities.admin');
    $options[\App\Models\Visibility::VISIBILITY_MEMBERS] = __('crud.visibilities.members');
}
if ($note->created_by == auth()->user()->id) {
    $options[\App\Models\Visibility::VISIBILITY_SELF] = __('crud.visibilities.self');
    $options[\App\Models\Visibility::VISIBILITY_ADMIN_SELF] = __('crud.visibilities.admin-self');
}

// If it's a visibility self & admin and we're not the creator, we can't change this
if ($note->visibility_id === \App\Models\Visibility::VISIBILITY_ADMIN_SELF && $note->created_by !== auth()->user()->id) {
    $options = [\App\Models\Visibility::VISIBILITY_ADMIN_SELF => __('crud.visibilities.admin-self')];
}
elseif ($note->visibility_id === \App\Models\Visibility::VISIBILITY_SELF && $note->created_by !== auth()->user()->id) {
    $options = [\App\Models\Visibility::VISIBILITY_SELF => __('crud.visibilities.self')];
}
@endphp
                    <select name="posts[{{ $note->id }}][visibility_id]" class="form-control">
                        @foreach ($options as $key => $value)
                            <option value="{{ $key }}" @if ($key == $note->visibility_id) selected="selected" @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endforeach
        @includeWhen(!$hasEntry, 'entities.pages.story.reorder._story')
    </div>
    <button class="btn2 btn-primary btn-block">
        {{ __('entities/story.reorder.save') }}
    </button>
</div>

{!! Form::close() !!}

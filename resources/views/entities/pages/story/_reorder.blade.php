<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Post[]|\Illuminate\Support\Collection $posts
 * @var \App\Models\Post $first
 */
use App\Enums\Visibility;
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
<x-form :action="['entities.story.reorder-save', $campaign, $entity]">
<div class="box-entity-story-reorder max-w-4xl flex flex-col gap-5">
    <div class="element-live-reorder sortable-elements flex flex-col gap-1">
        @includeWhen($startWithStory, 'entities.pages.story.reorder._story')

        @foreach($posts as $note)
            @if (!$hasEntry && $note->position >= 0)
                @php $hasEntry = true @endphp
                @include('entities.pages.story.reorder._story')
            @endif


            <x-reorder.child :id="$note->id">
                <input type="hidden" name="posts[{{ $note->id }}][id]" value="{{ $note->id }}" />
                <div class="dragger">
                    <x-icon class="fa-regular fa-sort" />
                </div>
                <div class="truncate flex-grow">
                    {!! $note->name !!}
                </div>
                <div class="px-2 grow-0">
                    <select name="posts[{{ $note->id }}][collapsed]" class="">
                        <option value="0">{{ __('entities/notes.states.expanded') }}</option>
                        <option value="1" @if ($note->collapsed()) selected="selected" @endif>{{ __('entities/notes.states.collapsed') }}</option>
                    </select>
                </div>

                <div class="self-end">
                    <select name="posts[{{ $note->id }}][visibility_id]" class="">
                        @foreach ($note->visibilityOptions() as $key => $value)
                            <option value="{{ $key }}" @if ($key == $note->visibility_id->value) selected="selected" @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </x-reorder.child>
        @endforeach
        @includeWhen(!$hasEntry, 'entities.pages.story.reorder._story')
    </div>
    <button class="btn2 btn-primary btn-block">
        {{ __('entities/story.reorder.save') }}
    </button>
</div>

</x-form>

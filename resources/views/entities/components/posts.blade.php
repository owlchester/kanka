@php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 * @var \App\Models\Post $post
 * @var \Illuminate\Database\Eloquent\Collection $pinnedPosts
 */
if (empty($entity)) {
    $entity = $model->entity;
}
$wrapper = false;
$entryShown = false;
if (!isset($pinnedPosts)) {
    $pinnedPosts = $entity->posts()->with(['permissions', 'location'])->ordered()->paginate(15);
    $wrapper = true;
}

$first = $pinnedPosts->first();
$postCount = 0;
@endphp

@if(isset($withEntry) && ($pinnedPosts->count() === 0 || (!empty($first) && $first->position >= 0)))
    @include('entities.components.entry')
    @php $entryShown = true; @endphp
    @include('partials.ads.inline')
@endif


@if($wrapper)
<div class="entity-posts entity-notes flex flex-col gap-5">
@endif
    @foreach ($pinnedPosts as $post)
        @if ($post->layout_id && isset($printing) && $printing === true)
            @continue
        @endif
        @if (isset($withEntry) && !$entryShown && $post->position >= 0)
            @include('entities.components.entry')
            @php $entryShown = true @endphp
        @endif
        @if ($post->layout && !$campaign->superboosted())
            @continue
        @endif
        @includeWhen($post->layout && $campaign->superboosted(), 'entities.components._post_layouts')
        @includeWhen(!$post->layout, 'entities.components._post')
        @includeWhen($postCount > 0 && $postCount % 3 === 0, 'partials.ads.inline')
        @php $postCount++; @endphp
    @endforeach


    @if (isset($withEntry) && !$entryShown)
        @include('entities.components.entry')
        @php $entryShown = true @endphp
        @include('partials.ads.inline')
    @endif

    @if ($pinnedPosts->currentPage() < $pinnedPosts->lastPage())
        <div class="text-center">
            @if (auth()->check())
            <a href="#" class="btn2  btn-sm story-load-more" data-url="{{ route('entities.story.load-more', [$campaign, $entity, 'page' => $pinnedPosts->currentPage() + 1]) }}">
                <i class="fa-solid fa-arrows-rotate" aria-hidden="true"></i> {{ __('entities/story.actions.load_more') }}
            </a>

            <i class="fa-solid fa-spinner fa-spin fa-2x" id="story-more-spinner" style="display: none"></i>
            @else
            <a href="{{ route('login') }}" class="btn2 btn-sm">
                {{ __('entities/story.actions.login_for_more') }}
            </a>

            @endif
        </div>
    @endif

@if($wrapper)
</div>
@endif

@if (!request()->ajax() && $entity && !$entity->isType([config('entities.ids.map'), config('entities.ids.timeline'), config('entities.ids.calendar')]))
@can('post', [$model, 'add'])
    <div class="text-center row-add-note-button">
        <a href="{{ route('entities.posts.create', [$campaign, $entity]) }}" class="btn2 btn-accent btn-sm btn-new-post"
           data-entity-type="post" data-toggle="tooltip" data-title="{{ __('crud.tooltips.new_post') }}">
            <x-icon class="plus"></x-icon>
            {{ __('crud.actions.new_post') }}
        </a>
    </div>
@endcan
@endif

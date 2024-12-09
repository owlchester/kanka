@php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 * @var \App\Models\Post $post
 * @var \Illuminate\Database\Eloquent\Collection $posts
 */
if (empty($entity)) {
    $entity = $model->entity;
}
$wrapper = false;
$entryShown = false;
if (!isset($posts)) {
    $pagination = config('limits.pagination');
    $posts = $entity->posts()->with(['permissions', 'location', 'layout'])->ordered()->paginate($pagination);
    $wrapper = true;
}

$first = $posts->first();
$postCount = 0;
@endphp

@if (isset($withEntry) && ($posts->count() === 0 || (!empty($first) && $first->position >= 0)))
    @include('entities.components.entry')
    @php $entryShown = true; @endphp
    @include('ads.inline')
@endif


@if ($wrapper && $posts->count() > 0)
<div class="entity-posts entity-notes flex flex-col gap-5">
@endif
    @foreach ($posts as $post)
        @if ($post->layout_id && isset($printing) && $printing === true)
            @continue
        @endif
        @if (isset($withEntry) && !$entryShown && $post->position >= 0)
            @include('entities.components.entry')
            @php $entryShown = true @endphp
        @endif
        @if ($post->layout_id && !$campaign->superboosted())
            @continue
        @endif
        @includeWhen($post->layout_id && $campaign->superboosted(), 'entities.components._post_layouts')
        @includeWhen(!$post->layout_id, 'entities.components._post')
        @includeWhen($postCount > 0 && $postCount % 3 === 0, 'ads.inline')
        @php $postCount++; @endphp
    @endforeach


    @if (isset($withEntry) && !$entryShown)
        @include('entities.components.entry')
        @php $entryShown = true @endphp
        @include('ads.inline')
    @endif

    @if ($posts->currentPage() < $posts->lastPage())
        <div class="text-center">
            @if (auth()->check())
            <a href="#" class="btn2  btn-sm story-load-more" data-url="{{ route('entities.story.load-more', [$campaign, $entity, 'page' => $posts->currentPage() + 1]) }}">
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

@if ($wrapper && $posts->count() > 0)
</div>
@endif

@if (!request()->ajax() && $entity && !$entity->isType([config('entities.ids.map'), config('entities.ids.timeline'), config('entities.ids.calendar')]))
@can('post', [$model, 'add'])
    <div class="text-center row-add-note-button">
        <a href="{{ route('entities.posts.create', [$campaign, $entity]) }}" class="btn2 btn-sm btn-new-post  btn-block"
           data-entity-type="post" data-toggle="tooltip" data-title="{{ __('crud.tooltips.new_post') }}">
            <x-icon class="plus" />
            {{ __('crud.actions.new_post') }}
        </a>
    </div>
@endcan
@endif

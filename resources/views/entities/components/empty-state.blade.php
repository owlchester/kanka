@php
    $canEdit = \Illuminate\Support\Facades\Gate::allows('update', [$entity]);
    $canPost = \Illuminate\Support\Facades\Gate::allows('post', [$entity]);
@endphp

@if ($canEdit || $canPost)
    <div class="bg-base-100 rounded-lg p-6 entity-empty-state">
        <h2 class="text-lg font-semibold mb-4">{{ __('entities/story.empty.title', ['name' => $entity->name]) }}</h2>

        <div class="grid grid-cols-1 {{ ($canEdit && $canPost) ? 'sm:grid-cols-2' : '' }} gap-3">
            @if ($canEdit)
                <a href="{{ route('entities.entry.edit', [$campaign, $entity]) }}"
                   class="group flex items-start gap-3 p-4 rounded-lg bg-base-200/60 hover:bg-base-200 transition-colors text-left">
                    <span class="shrink-0 mt-0.5 text-primary">
                        <x-icon class="fa-regular fa-feather fa-lg" />
                    </span>
                    <div>
                        <div class="font-medium text-base-content group-hover:text-primary transition-colors">
                            {{ __('entities/story.empty.entry.title') }}
                        </div>
                        <p class="text-sm text-base-content/70 mt-0.5 mb-0">
                            {{ __('entities/story.empty.entry.description') }}
                        </p>
                    </div>
                </a>
            @endif

            @if ($canPost)
                <a href="{{ route('entities.posts.create', [$campaign, $entity]) }}"
                   data-entity-type="post"
                   class="group flex items-start gap-3 p-4 rounded-lg bg-base-200/60 hover:bg-base-200 transition-colors text-left">
                    <span class="shrink-0 mt-0.5 text-primary">
                        <x-icon class="fa-regular fa-pen-to-square fa-lg" />
                    </span>
                    <div>
                        <div class="font-medium text-base-content group-hover:text-primary transition-colors">
                            {{ __('entities/story.empty.post.title') }}
                        </div>
                        <p class="text-sm text-base-content/70 mt-0.5 mb-0">
                            {{ __('entities/story.empty.post.description') }}
                        </p>
                    </div>
                </a>
            @endif
        </div>
    </div>
@else
    <div class="bg-base-100 rounded-lg p-6 text-center text-base-content/60 entity-empty-state">
        <p class="m-0">{{ __('entities/story.empty.read_only') }}</p>
    </div>
@endif

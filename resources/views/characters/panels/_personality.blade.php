<?php /** @var \App\Models\Entity $entity */
$traits = $entity->child->personality;
?>

@if (((auth()->check() && auth()->user()->can('personality', $entity->child)) || $entity->child->is_personality_visible) && count($traits) > 0)

    <div class="flex flex-col gap-3 post-block character-personalities">
        <div class="post-header flex gap-1 md:gap-2 items-center justify-between">
            <div class="flex gap-2 items-center cursor-pointer element-toggle group" data-animate="collapse" data-target="#character-personality-body">
                <x-icon class="fa-solid fa-chevron-up icon-show transition-transform duration-200 group-hover:-translate-y-0.5
" />
                <x-icon class="fa-solid fa-chevron-down icon-hide transition-transform duration-200 group-hover:translate-y-0.5
" />
                <h3 class="post-title truncate text-xl">
                    {{ __('characters.sections.personality') }}
                </h3>
            </div>
            @can('personality', $entity->child)
                <div class="">
                    @if (!$entity->child->is_personality_visible)
                        <x-icon class="lock" tooltip title="{{ __('characters.hints.personality_not_visible') }}" />
                    @else
                        <x-icon class="fa-regular fa-lock-open" tooltip title="{{ __('characters.hints.personality_visible') }}" />
                    @endif
                </div>
            @endif
        </div>
        <div class="bg-box rounded" id="character-personality">
            <div class="entity-content overflow-hidden" id="character-personality-body">
                <div class="flex flex-col gap-3 md:grid md:grid-cols-2 xl:grid-cols-3 p-4">
                    @foreach ($traits as $trait)
                        <p class="entity-trait-{{ \Illuminate\Support\Str::slug($trait->name) }}" data-word-count="{{ $trait->words }}">
                            <b>{{ $trait->name }}</b><br />
                            {!! nl2br(\App\Facades\Mentions::mapAny($trait, 'entry')) !!}
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

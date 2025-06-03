<?php /** @var \App\Models\Entity $entity */
$appearances = $entity->child->appearances;
?>

@if (count($appearances) > 0)
    <div class="flex flex-col gap-3 post-block post-block character-appearances">
        <div class="post-header flex gap-1 md:gap-2 items-center">
            <div class="flex gap-2 items-center cursor-pointer element-toggle group" data-animate="collapse" data-target="#character-appearance-body">
                <x-icon class="fa-solid fa-chevron-up icon-show transition-transform duration-200 group-hover:-translate-y-0.5" />
                <x-icon class="fa-solid fa-chevron-down icon-hide transition-transform duration-200 group-hover:translate-y-0.5" />
                <h3 class="post-title">
                    {{ __('characters.sections.appearance') }}
                </h3>
            </div>
        </div>
        <div class="bg-box rounded" id="character-appearance">
            <div class="entity-content overflow-hidden" id="character-appearance-body">
                <div class="flex flex-col gap-4 md:grid md:grid-cols-2 xl:grid-cols-3 p-4">
        @foreach ($appearances as $trait)
                <p class="entity-appearance-{{ \Illuminate\Support\Str::slug($trait->name) }}" data-word-count="{{ $trait->words }}">
                    <b>{{ $trait->name }}</b><br />
                    {!! $trait->entry !!}
                </p>
        @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

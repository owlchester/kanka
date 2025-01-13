<?php /** @var \App\Models\Entity $entity */
$appearances = $entity->child->appearances;
?>

@if (count($appearances) > 0)
    <div class="flex flex-col gap-3 post-block post-block character-appearances">
        <div class="post-header flex gap-1 md:gap-2 items-center">
            <div class="flex gap-2 items-center grow cursor-pointer element-toggle" data-animate="collapse" data-target="#character-appearance-body">
                <x-icon class="fa-solid fa-chevron-up icon-show" />
                <x-icon class="fa-solid fa-chevron-down icon-hide" />
                <h3 class="post-title grow m-0">
                    {{ __('characters.sections.appearance') }}
                </h3>
            </div>
        </div>
        <div class="bg-box rounded" id="character-appearance">
            <div class="entity-content overflow-hidden" id="character-appearance-body">
                <x-grid css="p-4">
        @foreach ($appearances as $trait)
                <p class="entity-appearance-{{ \Illuminate\Support\Str::slug($trait->name) }}">
                    <b>{{ $trait->name }}</b><br />
                    {{ $trait->entry }}
                </p>
        @endforeach
                </x-grid>
            </div>
        </div>
    </div>
@endif

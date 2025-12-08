<?php /** @var \App\Models\Feature $idea **/ ?>
<div>
    <div class="flex items-center mb-5 gap-2">
        <input type="text" wire:model.live.debounce.200ms="search" class="block-input grow" placeholder="Name of an idea">
    </div>

    <div class="flex flex-col gap-5">
        @foreach ($ideas as $idea)
            <div class="rounded-2xl overflow-hidden flex" wire:key="idea-block-{{ $idea->id }}">
                <div class="flex-none w-40 py-5 bg-purple text-white">
                    <div class="flex gap-2 align-center items-center justify-center text-md">
                        @livewire('roadmap.upvote', ['feature' => $idea], key("idea-{$idea->id}"))
                    </div>
                </div>
                <div class="bg-gray-200 p-5 grow flex flex-col gap-5 cursor-pointer hover:bg-light transition-all duration-300" wire:click="open({{ $idea }})">
                    <h2 class="text-md">{{ $idea->name }}</h2>
                    {!! $idea->cleanDescription() !!}
                </div>
            </div>
        @endforeach

        {{ $ideas->links('livewire.front-pagination', data: ['scrollTo' => '#ideas']) }}
    </div>
</div>

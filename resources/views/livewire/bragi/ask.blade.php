<div>
<div class="flex flex-col gap-4">
    @forelse ($messages as $message)
        @include('livewire.bragi.message', ['message' => $message])
    @empty
        <div class="rounded-2xl justify-center overflow-hidden flex">
            @if ($isLoading)
                {{__('bragi.loading')}}
            @elseif ($canAsk)
                {{__('bragi/ask-bragi.helper.bragi')}}
            @else
                {{__('bragi/ask-bragi.helper.uses')}}
            @endif
        </div>
    @endforelse
</div>
<br/>

<x-box class="mb-12 rounded-2xl">
    <x-slot name="title">
        {{ __('bragi/ask-bragi.title') }}
    </x-slot>
    <div>
        @if ($canAsk)
        <div class="flex flex-wrap gap-2 justify-between items-end">
            <div class="field field-query">
                <label>
                    @if ($isLoading)
                        {{__('bragi.loading')}}
                    @else
                        {{__('bragi/ask-bragi.helper.bragi')}}
                    @endif
                </label>
                <textarea wire:model="query" class="rounded text-dark w-full p-2" rows="5"></textarea>
            </div>
            <div class="text-right">
                <button wire:click="submit" class="btn2 btn-primary @if ($isLoading) btn-disabled loading @endif">  
                    {{ __('bragi/ask-bragi.actions.ask') }} 
                </button>
            </div>
        </div>
        @else
            {{ __('bragi/ask-bragi.helper.uses') }} 
        @endif
    </div>
</x-box>
</div>

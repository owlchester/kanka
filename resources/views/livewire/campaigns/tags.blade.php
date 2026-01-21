<div class="relative" wire:click.away="$set('open', false)">
    {{-- Selected tags --}}
    <div class="flex flex-wrap gap-2 mb-2">
        @foreach ($selected as $tag)
            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded flex items-center gap-1">
                {{ $tag['label'] }}
                <button
                    type="button"
                    wire:click="remove('{{ $tag['id'] }}')"
                    class="font-bold"
                >
                    ✕
                </button>
            </span>
        @endforeach
    </div>

    <input
        type="text"
        wire:model.live.debounce.350ms="search"
        wire:focus="show"
        class="w-full border rounded px-3 py-2"
        placeholder="Search tags..."
        autocomplete="off"
    >
    @if ($open && count($options))
        <ul class="absolute z-10 bg-white border w-full mt-1 rounded shadow max-h-60 overflow-y-auto">
            @foreach ($options as $option)
                <li
                    wire:click="select('{{ $option['id'] }}', '{{ $option['label'] }}')"
                    class="px-3 py-2 hover:bg-gray-100 cursor-pointer"
                >
                    {{ $option['label'] }}
                </li>
            @endforeach
        </ul>
    @endif
</div>

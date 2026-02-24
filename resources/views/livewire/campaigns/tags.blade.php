<div class="relative flex flex-col gap-1" wire:click.away="$set('open', false)">
    <label class="text-xs font-semibold opacity-80">
        {{ __('campaigns/import.csv.selected_tags') }}
    </label>
    <div class="flex flex-wrap gap-2 ">
        @foreach ($selected as $tag)
            <span class="bg-neutral text-neutral-content px-2 py-1 rounded-2xl text-xs flex items-center gap-1">
                {{ $tag['label'] }}
                <button
                    type="button"
                    wire:click="remove('{{ $tag['id'] }}')"
                    class="font-bold cursor-pointer"
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
        placeholder="Search tags"
        autocomplete="off"
    >
    @if ($open && count($options))
        <ul class="tippy-box ">
            @foreach ($options as $option)
                <li
                    wire:click="select('{{ $option['id'] }}', '{{ $option['label'] }}')"
                    class=" px-1.5 py-1.5 hover:bg-base-200 rounded flex items-center gap-1.5 text-sm text-base-content transition-all duration-150"
                >
                    {{ $option['label'] }}
                </li>
            @endforeach
        </ul>
    @endif
</div>

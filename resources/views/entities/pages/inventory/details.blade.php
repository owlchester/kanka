<?php
    /** @var \App\Models\Inventory $inventory */
?>
<x-dialog.header>
    {!! $inventory->itemName() !!}
</x-dialog.header>
<article class="max-w-2xl">

    <div class="flex flex-col gap-4">
        <div class="grid grid-cols-2 gap-4">
            @if ($inventory->item)
                @if ($inventory->item->price)
                    <div class="flex gap-2 items-center">
                        <div class="text-accent text-2xl">
                        <x-icon class="fa-duotone fa-building-columns" />
                        </div>
                        <div class="flex flex-col gap-0">
                            <div class="font-extrabold text-xl">
                                {{ $inventory->item->price }}
                            </div>
                            <div class="text-neutral-content">
                                {{ __('items.fields.price') }}
                            </div>
                        </div>
                    </div>
                @endif

                @if ($inventory->item->size)
                    <div class="flex gap-2 items-center">
                        <div class="text-accent text-2xl">
                            <x-icon class="fa-duotone fa-up-right-and-down-left-from-center" />
                        </div>
                        <div class="flex flex-col gap-0">
                            <div class="font-extrabold text-xl">
                                {{ $inventory->item->size }}
                            </div>
                            <div class="text-neutral-content">
                                {{ __('items.fields.size') }}
                            </div>
                        </div>
                    </div>
                @endif

                @if ($inventory->item->location)
                    <div class="flex gap-2 items-center">
                        <div class="text-accent text-2xl">
                            <x-icon class="fa-duotone fa-location-dot" />
                        </div>
                        <div class="flex flex-col gap-0">
                            <div class="font-extrabold text-xl">
                                {!! $inventory->item->location->tooltipedLink() !!}
                            </div>
                            <div class="text-neutral-content">
                                {{ \App\Facades\Module::singular(config('entities.ids.location'), __('entities.location'))  }}
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <div class="flex gap-2 items-center ">
                <div class="text-accent text-2xl">
                {!! $inventory->visibilityIcon() !!}
                </div>
                <div class="flex flex-col gap-0">
                    <div class="font-extrabold text-xl ">
                        {{ __($inventory->visibilityName()) }}
                    </div>
                    <div class="text-neutral-content">
                        {{ __('crud.fields.visibility') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 class="text-2xl">
        @if ($inventory->item)
            <a href="{{ route('entities.show', [$campaign, $inventory->item->entity]) }}">
                {!! $inventory->item->name !!}
            </a>
        @else
            {!! $inventory->name !!}
        @endif
    </h1>

    <p class="text-neutral-content">
        @if ($inventory->item && $inventory->copy_item_entry)
            {!! $inventory->item->entry() !!}
        @else
            {!! $inventory->description !!}
        @endif
    </p>
</article>


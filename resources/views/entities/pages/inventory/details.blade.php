<?php
    /** @var \App\Models\Inventory $inventory */
?>
<x-dialog.header>
    {!! $inventory->itemName() !!}
</x-dialog.header>
<article class="max-w-2xl">

    <div class="flex flex-col gap-4">
        <div class="flex gap-4">
            <div class="text-center self-center">
                @include('entities.pages.inventory._thumbnail', ['item' => $inventory])
            </div>
            <div class="grid grid-cols-2 gap-4">
                @if ($inventory->item)
                    @if ($inventory->item->price)
                        <div class="flex gap-2 items-center">
                            <div class="text-accent text-3xl">
                                <x-icon class="fa-duotone fa-coins" />
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
                            <div class="text-accent text-3xl">
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
                            <div class="text-accent text-3xl">
                                <x-icon class="fa-duotone fa-location-dot" />
                            </div>
                            <div class="flex flex-col gap-0">
                                <div class="font-extrabold text-xl">
                                    <x-entity-link
                                        :entity="$inventory->item->location->entity"
                                        :campaign="$campaign" />
                                </div>
                                <div class="text-neutral-content">
                                    {{ \App\Facades\Module::singular(config('entities.ids.location'), __('entities.location'))  }}
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <div class="flex gap-2 items-center ">
                    <div class="text-accent text-3xl">
                        @include('icons.visibility', ['icon' => $inventory->visibilityIcon()])
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

    </div>

    <div class="flex gap-2 items-center">
        <h1 class="text-2xl grow">
            @if ($inventory->item)
                <x-entity-link
                    :entity="$inventory->item->entity"
                    :campaign="$campaign" />
            @else
                {!! $inventory->name !!}
            @endif
        </h1>

    @if ($inventory->item)
        <div class="flex gap-2 item-entity-tags">
            @foreach ($inventory->item->entity->tags()->with('entity')->get() as $tag)
                @if (!$tag->entity) @continue @endif
                <x-tags.bubble :tag="$tag" />
            @endforeach
        </div>
    @endif
    </div>

    <p class="text-neutral-content">
        @if ($inventory->item && $inventory->copy_item_entry)
            {!! $inventory->item->parsedEntry() !!}
        @else
            {!! $inventory->description !!}
        @endif
    </p>
</article>


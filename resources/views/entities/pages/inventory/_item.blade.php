@php
 /** @var \App\Models\Inventory $item **/
$image = false;
if ($item->item && $item->item->entity->hasImage()) {
    $image = \App\Facades\Avatar::entity($item->item->entity)->size(192)->thumbnail();
} elseif ($item->image) {
    $image = $item->image->getUrl(192);
}
$itemName = '';
if ($item->item) {
    $itemName = $item->name ?: $item->item->name;
} else {
    $itemName = $item->name;
}
@endphp

<div class="flex flex-col gap-0 relative item-wrapper">
    <a
        class="w-40 h-40 bg-base-100 rounded relative bg-cover bg-center flex flex-col cursor-pointer overflow-hidden @if ($image === false) bg-base-200 @endif"
    @if ($item->item) data-object-size="{{ $item->item->size }}"
    data-object-price="{{ $item->item->price }}"
    data-object-weight="{{ $item->item->weight }}" @endif
    data-visibility="{{ $item->visibility_id }}"
    @if ($image !== false) style="background-image: url('{{ $image }}')" @endif
    data-toggle="dialog"
    data-url="{{ route('entities.inventory.details', [$campaign, $entity, $item]) }}"
    >


    @if ($item->isEquipped())
        <div class="left-2 top-2 absolute flex gap-1 text-neutral-content">
            <div class="rounded-full bg-base-200 w-6 h-6 flex items-center justify-center">
                <x-icon class="fa-regular fa-backpack" tooltip="1" :title="__('entities/inventories.tooltips.equipped')" />
            </div>
            @if (!$item->isVisibleAll())
                <div class="rounded-full bg-base-200 w-6 h-6 flex items-center justify-center">
                    @include('icons.visibility', ['icon' => $item->visibilityIcon()])
                </div>
            @endif

        </div>

    @endif

        <div class="grow flex items-center justify-center text-neutral-content text-4xl text-opacity-50">
            @if ($image === false)
                <x-icon class="fa-regular fa-treasure-chest"></x-icon>
            @endif
        </div>
        <div class="flex flex-col gap-0 items-center overflow-hidden bg-base-100 p-1 px-1.5 text-base-content justify-center h-12" >
            <div class="flex gap-1 items-center justify-center w-full">
                <span class="item-name truncate" data-toggle="tooltip" data-title="{{ $itemName }}">
                   {!! $itemName !!}
                </span>
            </div>


            @if ($item->amount > 1)
                <div class="item-amount">
                    x{!! number_format($item->amount) !!}
                </div>
            @endif

            <p class="text-xs text-neutral-content text-center mx-4 overflow-hidden cursor-pointer item-description hidden item-description" data-toggle="dialog" data-url="{{ route('entities.inventory.details', [$campaign, $entity, $item]) }}">
                @if ($item->item && $item->copy_item_entry)
                    {!! \Illuminate\Support\Str::limit(strip_tags($item->item->entity->parsedEntry()) ?? '', 100) !!}
                @else
                    {!! \Illuminate\Support\Str::limit($item->description ?? '', 100) !!}
                @endif
            </p>

            @if ($item->item)
                @if (!empty($item->item->price))
                <div class="object-price text-xs text-neutral-content text-center hidden">
                    <x-icon class="fa-duotone fa-coins" />
                    {{ $item->item->price }}
                </div>
                @endif
                @if (!empty($item->item->size))
                <div class="object-size text-xs text-neutral-content text-center hidden">
                    <x-icon class="fa-duotone fa-up-right-and-down-left-from-center" />
                    {{ $item->item->size }}
                </div>
                @endif
                @if (!empty($item->item->weight))
                <div class="object-weight text-xs text-neutral-content text-center hidden">
                    <x-icon class="fa-duotone fa-weight-hanging" />
                    {{ $item->item->weight }}
                </div>
                @endif
            @endif
        </div>
    </a>
</div>

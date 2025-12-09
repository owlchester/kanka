@php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item
 */
@endphp
<div class="flex flex-col gap-4" x-data="{ showPrice: {{ $entity->isLocation() ? 'true' : 'false' }}, showQuantity: true, showWeight: false, showSize: false }">
    <div class="flex gap-2 inventory-toggles flex-wrap justify-center md:justify-start">
        <span role="button" @click="showQuantity = !showQuantity" class="btn2 btn-sm">
            <x-icon class="fa-regular fa-hashtag" />
            <span x-cloak x-show="!showQuantity">
                {{ __('entities/inventories.togglers.show.quantity') }}
            </span>
            <span x-cloak x-show="showQuantity">
                {{ __('entities/inventories.togglers.hide.quantity') }}
            </span>
        </span>
        <span role="button" @click="showPrice = !showPrice" class="btn2 btn-sm">
            <x-icon class="fa-regular fa-coins" />
            <span x-cloak x-show="!showPrice">
                {{ __('entities/inventories.togglers.show.price') }}
            </span>
            <span x-cloak x-show="showPrice">
                {{ __('entities/inventories.togglers.hide.price') }}
            </span>
        </span>
        <span role="button" @click="showSize = !showSize" class="btn2 btn-sm">
            <x-icon class="fa-regular fa-up-right-and-down-left-from-center" />
            <span x-cloak x-show="!showSize">
                {{ __('entities/inventories.togglers.show.size') }}
            </span>
            <span x-cloak x-show="showSize">
                {{ __('entities/inventories.togglers.hide.size') }}
            </span>
        </span>
        <span role="button" @click="showWeight = !showWeight" class="btn2 btn-sm">
            <x-icon class="fa-regular fa-weight-hanging" />
            <span x-cloak x-show="!showWeight">
                {{ __('entities/inventories.togglers.show.weight') }}
            </span>
            <span x-cloak x-show="showWeight">
                {{ __('entities/inventories.togglers.hide.weight') }}
            </span>
        </span>
    </div>
    @foreach ($entity->orderedInventory() as $position => $items)
        <div class="flex flex-col gap-4" data-position="{{ \Illuminate\Support\Str::slug($position) }}">
            <div class="section-title flex justify-between gap-4 items-center">
                <div class="overflow-hidden text-xl flex items-center gap-1 cursor-pointer inventory-position grow" data-animate="collapse" data-target="#inventory-section-body-{{ \Illuminate\Support\Str::slug($position) }}">
                    <x-icon class="fa-regular fa-chevron-up collapsed:flip transition-all duration-150" />
                    <span class="truncate">{!! $position ?? __('entities/inventories.show.unsorted') !!}</span>
                </div>
                <div class="flex items-center gap-2 lg:gap-4">
                    @can('inventory', $entity)
                        <a
                            href="{{ route('entities.inventories.create', [$campaign, $entity, 'position' => $position]) }}"
                            class="btn2 btn-default btn-sm"
                            data-toggle="dialog"
                            data-url="{{ route('entities.inventories.create', [$campaign, $entity, 'position' => $position]) }}"
                        >
                            <x-icon class="plus" />
                        </a>
                        <a
                            href="#"
                            class="btn2 btn-default btn-sm text-error"
                            role="button"
                            data-toggle="dialog"
                            data-url="{{ route('confirm-delete', [$campaign, 'route' => route('entities.inventory.delete.section', [$campaign, $entity, $items['0']]), 'name' => $position, 'permanent' => true]) }}"
                            title="{{ __('crud.remove') }}">
                                <x-icon class="trash" />
                                <span class="sr-only">{{ __('crud.remove') }}</span>
                        </a>
                    @endcan
                </div>
            </div>
            <div class="flex gap-4 flex-wrap" id="inventory-section-body-{{ \Illuminate\Support\Str::slug($position) }}">
                @foreach ($items as $item)
                    @include('entities.pages.inventory._item')
                @endforeach
            </div>
        </div>
    @endforeach
</div>

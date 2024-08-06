@php /** @var \App\Models\Inventory $item **/ @endphp
<div class="w-full lg:w-80 h-60 bg-base-100 rounded relative" >

    <div class="left-2 top-1  text-lg absolute">
        @include('icons.visibility', ['icon' => $item->visibilityIcon()])
    </div>

    <div class="flex flex-col m-4 gap-1 items-center overflow-hidden cursor-pointer" data-toggle="dialog" data-url="{{ route('entities.inventory.details', [$campaign, $entity, $item]) }}" data-target="primary-dialog">
        @include('entities.pages.inventory._thumbnail')

        <div class="flex flex-col gap-0  items-center">
            <div class="text-xl text-accent item-amount">
                +{!! number_format($item->amount) !!}
            </div>

            <h3 class="text-lg font-extrabold item-name text-center w-full text-accent item-name">
            @if ($item->item)
                {!! $item->name ?: $item->item->name !!}
            @else
                {!! $item->name !!}
            @endif
            </h3>

            <p class="text-xs text-neutral-content text-center mx-4 overflow-hidden cursor-pointer item-description" data-toggle="dialog" data-url="{{ route('entities.inventory.details', [$campaign, $entity, $item]) }}" data-target="primary-dialog">
                @if ($item->item && $item->copy_item_entry)
                    {!! \Illuminate\Support\Str::limit(strip_tags($item->item->parsedEntry()), 100) !!}
                @else
                    {!! \Illuminate\Support\Str::limit($item->description, 100) !!}
                @endif
            </p>
        </div>
        </div>

    @if ($item->is_equipped)
        <div class="left-2 bottom-1 absolute text-lg">
            <x-icon class="fa-solid fa-backpack" tooltip="1" :title="__('entities/inventories.tooltips.equipped')" />
        </div>
    @endif

    @can('inventory', $entity->child)
    <div class="right-2 bottom-1 absolute  text-lg">
        <a href="{{ route('entities.inventories.edit', [$campaign, $entity, $item]) }}"
           class="link link-accent"
           data-toggle="dialog" data-target="primary-dialog"
           data-url="{{ route('entities.inventories.edit', [$campaign, $entity, $item]) }}"
           title="{{ __('crud.edit') }}">
            <x-icon class="edit" />
        </a>
    </div>
    @endcan
</div>

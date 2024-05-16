@php /** @var \App\Models\Inventory $item **/ @endphp
<div class="w-full lg:w-80 h-60 bg-base-100 rounded relative" >

    <div class="left-2 top-1  text-lg absolute">
        {!! $item->visibilityIcon() !!}
    </div>

    <div class="flex flex-col m-4 items-center overflow-hidden cursor-pointer" data-toggle="dialog" data-url="{{ route('entities.inventory.details', [$campaign, $entity, $item]) }}" data-target="primary-dialog">
        @if ($item->item && $item->item->entity->hasImage())
            <div class="w-24 h-24 rounded-full cover-background" style="background-image: url('{{ \App\Facades\Avatar::entity($item->item->entity)->size(192)->thumbnail() }}')" >
            </div>
        @else
            <div class="w-24 h-24 rounded-full bg-base-200 flex items-center justify-center align-center">
                <x-icon class="fa-duotone fa-gem text-6xl text-accent" />
            </div>
        @endif


        <div class="flex flex-col gap-1  items-center">
            <div class="text-xl text-accent relative">
                +{!! number_format($item->amount) !!}
            </div>

            <h3 class="text-lg font-extrabold item-name text-center w-full text-accent">
            @if ($item->item)
                {!! $item->name ?: $item->item->name !!}
            @else
                {!! $item->name !!}
            @endif
            </h3>

            <p class="text-xs text-neutral-content text-center mx-4 overflow-hidden cursor-pointer" data-toggle="dialog" data-url="{{ route('entities.inventory.details', [$campaign, $entity, $item]) }}" data-target="primary-dialog">
                @if ($item->item && $item->copy_item_entry)
                    {!! \Illuminate\Support\Str::limit(strip_tags($item->item->entry()), 100) !!}
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

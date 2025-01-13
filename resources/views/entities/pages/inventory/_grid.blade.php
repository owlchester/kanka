@php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item
 */
@endphp
<div class="flex flex-col gap-4">
    @foreach ($entity->orderedInventory() as $position => $items)
        <div class="flex flex-col gap-4" data-position="{{ \Illuminate\Support\Str::slug($position) }}">
            <div class="section-title flex gap-4 items-center">
                <h2 class="grow text-2xl flex items-center gap-1 cursor-pointer" data-animate="collapse" data-target="#inventory-section-body-{{ \Illuminate\Support\Str::slug($position) }}">
                    <x-icon class="fa-solid fa-chevron-up collapsed:flip transition-all duration-150" />
                    {!! $position ?? "Unsorted" !!}
                </h2>
                <div class="flex items-center gap-4">
                    <a href="#" class="rounded hidden link link-accent bg-box">
                        <x-icon class="fa-solid fa-copy" />
                    </a>
                    @can('inventory', $entity)
                        <a href="{{ route('entities.inventories.create', [$campaign, $entity, 'position' => $position]) }}"
                           class="btn2 btn-default btn-sm"
                           data-toggle="dialog" data-target="primary-dialog"
                           data-url="{{ route('entities.inventories.create', [$campaign, $entity, 'position' => $position]) }}"
                        >
                            <x-icon class="plus" />
                        </a>

                        <a href="#" class="rounded hidden link link-accent bg-box">
                            <x-icon class="fa-solid fa-times" />
                        </a>
                        <td class="text-right">
                            <a href="#" class="btn2 btn-default btn-sm text-error"
                               role="button"
                                data-toggle="dialog"
                                data-target="primary-dialog"
                                data-url="{{ route('confirm-delete', [$campaign, 'route' => route('entities.inventory.delete.section', [$campaign, $entity, $items['0']]), 'name' => $position, 'permanent' => true]) }}"
                                title="{{ __('crud.remove') }}">
                                    <x-icon class="trash" />
                                    <span class="sr-only">{{ __('crud.remove') }}</span>
                                </a>
                        </td>
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

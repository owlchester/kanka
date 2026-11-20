<?php /** @var \App\Datagrids\Sorters\QuestElementSorter $datagridSorter */?>
@if (!empty($datagridSorter) && auth()->check())
    @php
        $baseRoute = request()->url() . '?' . (!empty($allMembers) ? 'all_members=1&' : (isset($filter) ? $filter : null));
    @endphp
    <div class="dropdown">
        <a role="button" class="btn2 btn-sm" data-dropdown aria-expanded="false">
            <i class="fa-regular fa-arrow-down-a-z" aria-hidden="true" data-tree="escape"></i>
            <span class="sr-only">Order by</span>
        </a>
        <div class="dropdown-menu hidden" role="menu">
            @foreach ($datagridSorter->options() as $key => $val)
                <x-dropdowns.item
                    :link="$baseRoute . $datagridSorter->fieldname() . '=' . $key . $datagridSorter->direction()"
                    :active="$datagridSorter->isSelected($key)">
                    {{ __('crud.filters.sorting.asc', ['field' => __($val)]) }}
                </x-dropdowns.item>

                <x-dropdowns.item
                    :link="$baseRoute . $datagridSorter->fieldname() . '=' . $key . $datagridSorter->direction(false)"
                    :active="$datagridSorter->isSelected($key, false)">
                    {{ __('crud.filters.sorting.desc', ['field' => __($val)]) }}
                </x-dropdowns.item>
            @endforeach
        </div>
    </div>
@endif

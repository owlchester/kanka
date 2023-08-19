<?php /** @var \App\Datagrids\Sorters\DatagridSorter $datagridSorter */?>
@if (!empty($datagridSorter) && auth()->check())
    @php
        $baseRoute = request()->url() . '?' . (!empty($allMembers) ? 'all_members=1&' : (isset($filter) ? $filter : null));
    @endphp
    <div class="dropdown">
        <a role="button" class="dropdown-toggle btn2 btn-sm" data-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-arrow-down-a-z" aria-hidden="true" data-tree="escape"></i>
            <span class="sr-only">Order by</span>
        </a>
        <ul class="dropdown-menu min-w-0" role="menu">
            @foreach ($datagridSorter->options($campaign) as $key => $val)
                @if ($key === 'today')
                    <li class="dropdown-item" @if ($datagridSorter->isSelected($key)) active @endif>
                        <a href="{{ $baseRoute . $datagridSorter->fieldname() . '=' . $key . $datagridSorter->direction() }}">
                            {{ __('calendars.sorters.after') }}
                        </a>
                    </li>
                    <li class="dropdown-item" @if ($datagridSorter->isSelected($key, false)) active @endif>
                        <a href="{{ $baseRoute . $datagridSorter->fieldname() . '=' . $key . $datagridSorter->direction(false) }}">
                        {{ __('calendars.sorters.before') }}
                        </a>
                    </li>
                @else
                    <li class="dropdown-item @if ($datagridSorter->isSelected($key)) active @endif">
                        <a href="{{ $baseRoute . $datagridSorter->fieldname() . '=' . $key . $datagridSorter->direction() }}">
                            {{ __('crud.filters.sorting.asc', ['field' => __($val)]) }}
                        </a>
                    </li>

                    <li class="dropdown-item @if ($datagridSorter->isSelected($key, false)) active @endif">
                        <a href="{{ $baseRoute . $datagridSorter->fieldname() . '=' . $key . $datagridSorter->direction(false) }}">
                            {{ __('crud.filters.sorting.desc', ['field' => __($val)]) }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif


@if ($mode === 'grid')
    <div class="dropdown">
        <a role="button" tabindex="0" class="dropdown-toggle btn2" data-toggle="dropdown" aria-expanded="false" aria-haspopup="menu" aria-controls="toggler-submenu" aria-label="Order by">
            <i class="fa-solid fa-arrow-down-a-z" aria-hidden="true" data-tree="escape"></i>
            <span class="sr-only">Order by</span>
        </a>
        <ul class="dropdown-menu min-w-0" role="menu" id="toggler-submenu">
            @foreach ($model->datagridSortableColumns() as $field => $translation)
                @php
                    $options = [$campaign, 'm' => $mode, 'order' => $field];
                    $icon = null;
                    if (request()->get('order') === $field) {
                        if (request()->get('desc') === '1') {
                            $icon = '<i class="fa-solid fa-arrow-down-a-z !mr-0" aria-hidden="true"></i>';
                        } else {
                            $options['desc'] = 1;
                            $icon = '<i class="fa-solid fa-arrow-up-a-z !mr-0" aria-hidden="true"></i>';
                        }
                    }
                @endphp
                <li class="dropdown-item">
                    <a href="{{ route($name . '.' . $route, $options) }}" title="{{ $translation }}" class="{{ request()->get('order') === $field ? "font-bold" : null }}">
                        {!! $icon !!}
                        {{ $translation }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif

@if (empty($forceMode))
    @if (!isset($mode) || $mode === 'grid')
        <a class="btn2 " href="{{ route($name . '.' . $route, [$campaign, 'm' => 'table']) }}" title="{{ __('datagrids.modes.table') }}">
            <x-icon class="fa-solid fa-list-ul"></x-icon>
            <span class="sr-only">Table</span>
        </a>
    @else
        <a class="btn2" href="{{ route($name . '.' . $route, [$campaign, 'm' => 'grid']) }}" title="{{ __('datagrids.modes.grid') }}">
            <i class="fa-solid fa-grid !mr-0" aria-hidden="true"></i>
            <span class="sr-only">Grid</span>
        </a>
    @endif
@endif

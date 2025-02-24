@if (isset($model) && $mode === 'grid' && auth()->check() && !$entityType->isSpecial())
    <div class="dropdown">
        <a role="button" tabindex="0" class="btn2" data-dropdown aria-expanded="false" aria-haspopup="menu" aria-controls="toggler-submenu" aria-label="Order by">
            <i class="fa-solid fa-arrow-down-a-z" aria-hidden="true" data-tree="escape"></i>
            <span class="sr-only">Order by</span>
        </a>
        <div class="dropdown-menu hidden" role="menu" id="toggler-submenu">
            @foreach ($model->datagridSortableColumns() as $field => $translation)
                @php
                    $options = [$campaign, 'order' => $field];
                    if (isset($bookmark)) {
                        $options['bookmark'] = $bookmark;
                    }
                    $icon = null;
                    if (isset($order) && $order === $field) {
                        if (isset($desc) && $desc == 1) {
                            $icon = 'fa-solid fa-arrow-down-a-z';
                        } else {
                            $options['desc'] = 1;
                            $icon = 'fa-solid fa-arrow-up-a-z';
                        }
                    }
                @endphp
                <x-dropdowns.item :link="route($route, $options)" :css="isset($order) && $order === $field ? 'font-bold' : null" :icon="$icon">
                    {{ $translation }}
                </x-dropdowns.item>
            @endforeach
        </div>
    </div>
@endif

@if (empty($forceMode))
    @if (!isset($mode) || $mode === 'grid')
        <a class="btn2 " href="{{ route($route, [$campaign, 'm' => 'table', 'bookmark' => $bookmark ?? null]) }}" data-toggle="tooltip" data-title="{{ __('datagrids.modes.table') }}">
            <x-icon class="fa-solid fa-list-ul" />
            <span class="sr-only">{{ __('datagrids.modes.table') }}</span>
        </a>
    @else
        <a class="btn2" href="{{ route($route, [$campaign, 'm' => 'grid', 'bookmark' => $bookmark ?? null]) }}" data-toggle="tooltip" data-title="{{ __('datagrids.modes.grid') }}">
            <x-icon class="fa-solid fa-grid" />
            <span class="sr-only">{{ __('datagrids.modes.grid') }}</span>
        </a>
    @endif
@endif

@if ((isset($nestable) && empty($forceMode)) || (isset($entityType) && $entityType->isSpecial()))
    @if ($nestable)
        <a class="btn2" href="{{ route($route, array_merge([$campaign, 'n' => false, 'bookmark' => $bookmark ?? null], [isset($entityType) && $entityType->isSpecial() ? $entityType : null])) }}" data-toggle="tooltip" data-title="{{ __('datagrids.modes.flatten') }}">
            <x-icon class="fa-solid fa-boxes-stacked" />
            <span class="sr-only">{{ __('datagrids.modes.flatten') }}</span>
        </a>
    @else
        <a class="btn2" href="{{ route($route, array_merge([$campaign, 'n' => true, 'bookmark' => $bookmark ?? null], [isset($entityType) && $entityType->isSpecial() ? $entityType : null])) }}" data-toggle="tooltip" data-title="{{ __('datagrids.modes.nested') }}">
            <x-icon class="fa-solid fa-layer-group" />
            <span class="sr-only">{{ __('datagrids.modes.nested') }}</span>
        </a>
    @endif
@endif

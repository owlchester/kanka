<?php
/** @var \App\Models\Ability $model */
// Only get the data by AJAX if this is included with a 'onload' param
$allChildren = request()->has('parent_id');
$datagridOptions = [];

if (!empty($onload)) {
    $routeOptions = [
        $campaign,
        $model,
        'init' => 1,
    ];
    if ($allChildren) {
        $routeOptions['parent_id'] = $model->id;
    }
    $routeOptions = Datagrid::initOptions($routeOptions);
    $datagridOptions =
        ['datagridUrl' => route('abilities.abilities', $routeOptions)]
    ;
}
?>
@if (!empty($onload))
    @php
    $direct = $model->descendants()->count();
    $all = $model->children()->count();
    @endphp
<div class="flex gap-2 items-center">
    <h3 class="grow">
        {!! \App\Facades\Module::plural(config('entities.ids.ability'), __('entities.abilities')) !!}
    </h3>
    <div class="flex gap-2 flex-wrap overflow-auto">
        @if (!$allChildren)
            <a href="{{ route('entities.show', [$campaign, $entity, 'parent_id' => $model->id, '#abilities-abilities']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">
                    {{ __('crud.filters.lists.desktop.all', ['count' => $all]) }}
                </span>
                <span class="xl:hidden">
                    {{ $all }}
                </span>
            </a>
        @else
            <a href="{{ $entity->url() }}" class="btn2 btn-sm">
                <x-icon class="filter" />

                <span class="hidden xl:inline">
                    {{ __('crud.filters.lists.desktop.filtered', ['count' => $direct]) }}
                </span>
                <span class="xl:hidden">
                    {{ $direct  }}
                </span>
            </a>
        @endif
    </div>
</div>
@endif
<div id="abilities-abilities" class="overflow-auto">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', $datagridOptions)
    </div>
</div>

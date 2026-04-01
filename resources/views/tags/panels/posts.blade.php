<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Tag $model
 */
$model = $entity->child;
$datagridOptions = [];

if (!empty($onload)) {
    $routeOptions = [
        $campaign,
        $model,
        'init' => 1,
    ];
    $routeOptions = Datagrid::initOptions($routeOptions);
    $datagridOptions =
        ['datagridUrl' => route('tags.posts', $routeOptions)]
    ;
}

$all = $model->posts()->count();
?>
<div class="flex gap-2 items-center justify-between">
    <h3 class="text-xl">
        {{ __('entities.articles') }}
    </h3>
    @if ($all > 0)
        @can('update', $entity)
            <div class="dropdown flex items-center">
                <div role="button" tabindex="0" data-dropdown aria-expanded="false" aria-haspopup="menu" class="btn2 btn-sm">
                    <x-icon class="fa-regular fa-ellipsis-h" />
                </div>
                <div class="dropdown-menu hidden" role="menu">

                    <x-dropdowns.item
                        :link="route('tags.transfer.posts', [$campaign, $model])"
                        icon="fa-regular fa-arrow-right"
                    >
                        {{ __('tags.transfer.transfer') }}
                    </x-dropdowns.item>
                </div>
            </div>
        @endcan
    @endif
</div>
@if ($all === 0)
<div class="" id="tag-children">
    <x-box>
        <x-helper>
            <p>{{ __('tags.helpers.no_posts') }}</p>
        </x-helper>
    </x-box>
</div>
@else
<div class="" id="tag-children">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', $datagridOptions)
    </div>
</div>
@endif

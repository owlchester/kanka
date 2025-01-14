<?php
/**
 * @var \App\Models\Tag $model
 */
$datagridOptions = [];

if (!empty($onload)) {
    $routeOptions = [
        $campaign,
        $model,
        'init' => 1,
    ];    
    $routeOptions = Datagrid::initOptions($routeOptions);
    $datagridOptions =
        ['datagridUrl' => route('tags.children.posts', $routeOptions)]
    ;
}

$all = $model->posts()->count();
?>
<div class="flex flex-col xl:flex-row gap-2 items-center">
    <h3 class="grow">
        {{ __('tags.show.tabs.posts') }}
    </h3>
    <div class="flex gap-2 flex-wrap overflow-auto">
        <button data-url="{{ route('tags.transfer', [$campaign, $model->id]) }}" data-toggle="dialog" data-target="primary-dialog" class="btn2 btn-sm">
            <x-icon class="fa-solid fa-arrow-right"/>
            <span class="hidden xl:inline">{{ __('tags.transfer.transfer') }}</span>
        </button>
    </div>
</div>
@if ($all === 0)
<div class="" id="tag-children">
    <x-box>
        <x-helper :text="__('tags.helpers.no_posts')" />
    </x-box>
</div>
@else
<div class="" id="tag-children">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', $datagridOptions)
    </div>
</div>
@endif

<?php /** @var \App\Models\Calendar $model */
$options = ['calendar' => $model->id];
$redirect = [];
if (request()->get('layout') === 'year') {
    $redirect[] = 'layout=year';
}
if (request()->has('year') && is_numeric(request()->has('year'))) {
    $redirect[] = 'year=' . request()->get('year');
}
if (request()->has('month') && is_numeric(request()->has('month'))) {
    $redirect[] = 'month=' . request()->get('month');
}
if (!empty($redirect)) {
    $options['redirect'] = implode("&", $redirect);
}
?>
@section('entity-header-actions-override')
    <div class="header-buttons inline-block pull-right ml-auto">
        <div class="btn-group">
            <div class="btn btn-default btn-sm btn-post-collapse" title="{{ __('entities/story.actions.collapse_all') }}" data-toggle="tooltip">
                <i class="fa-solid fa-grip-lines" aria-hidden="true"></i>
            </div>
            <div class="btn btn-default btn-sm btn-post-expand" title="{{ __('entities/story.actions.expand_all') }}" data-toggle="tooltip">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </div>
        </div>
        @can('update', $model)
            <a href="{{ route('calendars.edit', $options) }}" class="btn btn-primary btn-sm ">
                <i class="fa-solid fa-pencil" aria-hidden="true"></i> {{ __('crud.edit') }}
            </a>
        @endcan
        @can('post', [$model, 'add'])
            <a href="{{ route('entities.posts.create', $model->entity) }}" class="btn btn-warning btn-sm btn-new-post"
               data-entity-type="post" data-toggle="tooltip" title="{{ __('crud.tooltips.new_post') }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('crud.actions.new_post') }}
            </a>
        @endcan
    </div>
@endsection

<div class="entity-grid">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index('calendars'), 'label' => \App\Facades\Module::plural(config('entities.ids.calendar'), __('entities.calendars'))],
            null
        ],
        'entityHeaderActions' => 'entity-header-actions-override',
    ])

    @include($name . '._menu', ['active' => 'story', 'withPins'])

    <div class="entity-main-block">

        @include('entities.components.entry')
        @include('calendars._calendar')
        @include('entities.components.posts')

        @include('entities.pages.logs.history')
    </div>
</div>

<!-- We need this for tailwind to include the definitions -->
<template id="moon-colours">
    <div class="text-blue-500"></div>
    <div class="text-orange-900"></div>
    <div class="text-green-500"></div>
    <div class="text-blue-300"></div>
    <div class="text-pink-800"></div>
    <div class="text-blue-900"></div>
    <div class="text-orange-500"></div>
    <div class="text-pink-500"></div>
    <div class="text-purple-500"></div>
    <div class="text-red-500"></div>
    <div class="text-teal-500"></div>
    <div class="text-yellow-500"></div>
    <div class="text-gray-500"></div>
</template>

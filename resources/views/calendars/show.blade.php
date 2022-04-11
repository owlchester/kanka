<?php /** @var \App\Models\Calendar $model */
$options = ['calendar' => $model->id];
$redirect = [];
if (request()->get('layout') === 'year') {
    $redirect[] = 'layout=year';
}
if (request()->has('year')) {
    $redirect[] = 'year=' . request()->get('year');
}
if (request()->has('month')) {
    $redirect[] = 'month=' . request()->get('month');
}
if (!empty($redirect)) {
    $options['redirect'] = implode("&", $redirect);
}
?>
@section('entity-header-actions-override')
    <div class="header-buttons">
        <div class="btn-group">
            <div class="btn btn-default btn-sm btn-post-collapse" title="{{ __('entities/story.actions.collapse_all') }}" data-toggle="tooltip">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div class="btn btn-default btn-sm btn-post-expand" title="{{ __('entities/story.actions.expand_all') }}" data-toggle="tooltip">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        @can('update', $model)
            <a href="{{ route('calendars.edit', $options) }}" class="btn btn-primary btn-sm ">
                <i class="fa fa-pencil"></i> {{ __('crud.edit') }}
            </a>
        @endcan
        @can('entity-note', [$model, 'add'])
            <a href="{{ route('entities.entity_notes.create', $model->entity) }}" class="btn btn-warning btn-sm"
               data-toggle="tooltip" title="{{ __('crud.tooltips.new_post') }}">
                <i class="fa fa-plus"></i> {{ __('crud.actions.new_post') }}
            </a>
        @endcan
    </div>
@endsection

<div class="entity-grid">
    @include('entities.components.header_grid', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
            null
        ],
        'entityHeaderActions' => 'entity-header-actions-override',
    ])

    @include($name . '._menu', ['active' => 'story', 'withPins'])

    <div class="entity-main-block">

        @include('entities.components.entry')
        @include('calendars._calendar')
        @include('entities.components.notes')

        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>
</div>

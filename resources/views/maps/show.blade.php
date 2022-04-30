<?php /** @var \App\Models\Map $model */?>

<div class="entity-grid">
    @include('entities.components.header_grid', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
            null
        ]
    ])

    @include($name . '._menu', ['active' => 'story'])

    <div class="entity-story-block">
        @include('entities.components.notes', ['withEntry' => true])

        @if (!empty($model->image))
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <a href="{{ route('maps.explore', $model) }}" class="btn btn-block btn-primary" target="_blank">
                            <i class="fa-solid fa-map"></i> {{ __('maps.actions.explore') }}
                        </a>
                    </p>
                </div>
            </div>
        @endif

        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>

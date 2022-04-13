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
                        @if ($model->isChunked() && $model->chunkingError())
                            <p class="alert alert-error">
                                {!! __('maps.errors.chunking.error', ['discord' => link_to(config('social.discord'), 'Discord', ['target' => '_blank'])]) !!}
                            </p>
                        @elseif ($model->isChunked() && !$model->chunkingReady())
                            <p class="alert alert-warning">
                                {{ __('maps.errors.chunking.running.explore') }}
                                {{ __('maps.errors.chunking.running.time') }}
                            </p>
                        @else
                        <p>
                            <a href="{{ route('maps.explore', $model) }}" class="btn btn-block btn-primary" target="_blank">
                                <i class="fa fa-map"></i> {{ __('maps.actions.explore') }}
                            </a>
                        </p>
                        @endif
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

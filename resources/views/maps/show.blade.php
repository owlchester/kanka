<?php /** @var \App\Models\Map $model */?>

<div class="entity-grid">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index('maps'), 'label' => \App\Facades\Module::plural(config('entities.ids.map'), __('entities.maps'))],
            null
        ]
    ])

    @include($name . '._menu', ['active' => 'story'])

    <div class="entity-story-block">
        @include('entities.components.posts', ['withEntry' => true])

        @if (!empty($model->image) || $model->isReal())
            <div class="row">
                <div class="col-md-12">
                        @if ($model->isChunked() && $model->chunkingError())
                            <x-alert type="error">
                                {!! __('maps.errors.chunking.error', ['discord' => link_to(config('social.discord'), 'Discord', ['target' => '_blank'])]) !!}
                            </x-alert>
                        @elseif ($model->isChunked() && !$model->chunkingReady())
                            <x-alert type="warning">
                                {{ __('maps.errors.chunking.running.explore') }}
                                {{ __('maps.errors.chunking.running.time') }}
                            </x-alert>
                        @else
                        <p>
                            <a href="{{ route('maps.explore', $model) }}" class="btn btn-block btn-primary" target="_blank">
                                <x-icon class="map"></x-icon> {{ __('maps.actions.explore') }}
                            </a>
                        </p>
                        @endif
                </div>
            </div>
        @endif

        @include('entities.pages.logs.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>

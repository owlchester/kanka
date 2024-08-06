<?php /** @var \App\Models\Map $model */?>

<div class="entity-grid flex flex-col gap-5">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            Breadcrumb::entity($model->entity)->list(),
            null
        ]
    ])

    <div class="entity-body flex flex-col md:flex-row gap-5">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5 min-w-0">@if ($model->explorable())
                @if ($model->isChunked() && $model->chunkingError())
                    <x-alert type="error">
                        {!! __('maps.errors.chunking.error', ['discord' => '<a href="' . config('social.discord') . '" target="_blank">Discord</a>']) !!}
                    </x-alert>
                @elseif ($model->isChunked() && !$model->chunkingReady())
                    <x-alert type="warning">
                        {{ __('maps.errors.chunking.running.explore') }}
                        {{ __('maps.errors.chunking.running.time') }}
                    </x-alert>
                @else
                    <p>
                        <a href="{{ route('maps.explore', [$campaign, $model]) }}" class="btn2 btn-block btn-primary" target="_blank">
                            <x-icon class="map" /> {{ __('maps.actions.explore') }}
                        </a>
                    </p>
                @endif
            @endif

            @include('entities.components.posts', ['withEntry' => true])


        </div>

        @include('entities.components.pins')
    </div>
</div>

<?php /** @var \App\Models\Map $model */?>

<div class="entity-grid flex flex-col gap-5">
    @include('entities.components.header')

    <div class="entity-body flex flex-col md:flex-row gap-5">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5 min-w-0">@if ($entity->child->explorable())
                @if ($entity->child->tilingError())
                    <x-alert type="error">
                        {!! __('maps.errors.tiling.error', ['discord' => '<a href="https://kanka.io/go/discord">Discord</a>']) !!}
                    </x-alert>
                @elseif ($entity->child->tilingRunning())
                    <x-alert type="warning">
                        {{ __('maps.errors.tiling.running.explore') }}
                        {{ __('maps.errors.tiling.running.time') }}
                    </x-alert>
                @else
                    <p>
                        <a href="{{ route('maps.explore', [$campaign, $entity->child]) }}" class="btn2 btn-block btn-primary" target="_blank">
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

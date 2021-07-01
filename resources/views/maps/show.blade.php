<?php /** @var \App\Models\Map $model */?>
<div class="row entity-grid">
    <div class="col-md-2 entity-sidebar-submenu">
        @include('maps._menu', ['active' => 'story'])
    </div>

    <div class="col-md-8 entity-story-block">
        @if (!empty($model->image))
        <div class="row">
            <div class="col-md-12">
                <p>
                    <a href="{{ route('maps.explore', $model) }}" class="btn btn-block btn-primary" target="_blank">
                <i class="fa fa-map"></i> {{ __('maps.actions.explore') }}
                    </a>
                </p>
            </div>
        </div>
        @endif

        @include('entities.components.entry')
        @include('entities.components.notes')

        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="col-md-2 entity-sidebar-pins">
        @include('entities.components.pins')
    </div>
</div>


<?php /** @var \App\Models\Character $model */?>
<div class="row entity-grid">
    <div class="col-md-2 entity-sidebar-submenu">
        @include('characters._menu', ['active' => 'story'])
    </div>

    <div class="col-md-8 entity-story-block">

        @include('entities.components.notes', ['withEntry' => true])

        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="col-md-2 entity-sidebar-pins">
        @include('entities.components.pins')
    </div>
</div>

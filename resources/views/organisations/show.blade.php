<div class="row entity-grid">
    <div class="col-md-2 entity-sidebar-submenu">
        @include('organisations._menu', ['active' => 'story'])
    </div>



    <div class="col-md-8 entity-story-block">
        @include('entities.components.entry')
        @include('entities.components.notes')

        @include('organisations.panels._members')

        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="col-md-2 entity-sidebar-pins">
        @include('entities.components.pins')
    </div>
</div>

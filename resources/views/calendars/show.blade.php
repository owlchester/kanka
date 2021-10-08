@include('partials.errors')
<div class="row entity-grid">
    <div class="col-md-2 entity-sidebar-submenu">

        @include('entities.components.pins')
        @include('calendars._menu', ['active' => 'story'])
    </div>

    <div class="col-md-10 entity-story-block">
        @include('entities.components.entry')

        @include('calendars._calendar')

        @include('entities.components.notes')

        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>
</div>


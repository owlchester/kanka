<div class="row entity-grid">
    <div class="col-md-2 entity-sidebar-submenu">
        @include('journals._menu', ['active' => 'story'])
    </div>

    <div class="col-md-8 entity-story-block">
        @include('entities.components.notes')

        <div class="box box-solid">
            <div class="box-body">
                @include('dice_rolls._results')
            </div>
        </div>
        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="col-md-2 entity-sidebar-pins">
        @include('entities.components.pins')
    </div>
</div>

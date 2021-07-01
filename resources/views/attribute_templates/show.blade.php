<div class="row entity-grid">
    <div class="col-md-2 entity-sidebar-submenu">
        @include('attribute_templates._menu', ['active' => 'story'])
    </div>

    <div class="col-md-10 entity-main-block">
        <div class="box box-solid">
            <div class="box-body">
                @include('cruds._attributes')
            </div>
        </div>
        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>
</div>

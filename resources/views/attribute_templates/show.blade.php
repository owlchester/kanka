<div class="row">
    <div class="col-md-2">
        @include('attribute_templates._menu')
    </div>

    <div class="col-md-10">
        <div class="box box-solid">
            <div class="box-body">
                @include('cruds._attributes')
            </div>
        </div>
        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>
</div>

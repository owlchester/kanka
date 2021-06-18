<div class="row">
    <div class="col-md-2">
        @include('journals._menu')
    </div>

    <div class="col-md-8">
        @include('entities.components.entry')
        @include('entities.components.notes')

        <div class="box box-solid">
            <div class="box-body">
                @include('dice_rolls._results')
            </div>
        </div>
        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="col-md-2">
        @include('entities.components.pins')
    </div>
</div>

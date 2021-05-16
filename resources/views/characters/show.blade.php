<?php /** @var \App\Models\Character $model */?>
<div class="row">
    <div class="col-lg-2">
        @include('characters._menu')
    </div>

    <div class="col-lg-8">

        @include('entities.components.entry')
        @include('entities.components.notes')


        @include('cruds.boxes.history')
    </div>

    <div class="col-lg-2">
        @include('entities.components.pins')
    </div>
</div>

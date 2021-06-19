<div class="row">
    <div class="col-md-2">
        @include('organisations._menu', ['active' => 'story'])
    </div>



    <div class="col-md-8">

        @include('entities.components.entry')
        @include('entities.components.notes')

        @include('organisations.panels._members')


        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="col-md-2">
        @include('entities.components.pins')
    </div>
</div>

@include('partials.errors')
<div class="row">
    <div class="col-md-2">

        @include('entities.components.pins')
        @include('calendars._menu')
    </div>


    <div class="col-md-10">

        @include('entities.components.entry')

        @include('calendars._calendar')

        @include('entities.components.notes')


        @include('cruds.boxes.history')
    </div>

</div>

@section('scripts')
    @parent
    <script src="/vendor/spectrum/spectrum.js" defer></script>
@endsection


@section('styles')
    @parent
    <link href="/vendor/spectrum/spectrum.css" rel="stylesheet">
@endsection


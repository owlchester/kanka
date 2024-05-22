{!! $slot !!}

<div class="entity-content">
    {!! $model->parsedEntry() !!}
</div>

@include('dashboard.widgets.previews._members')
@include('dashboard.widgets.previews._relations')
@include('dashboard.widgets.previews._attributes')

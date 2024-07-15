{!! $slot !!}

@if ($model->hasEntry())
<div class="entity-content">
    {!! $model->parsedEntry() !!}
</div>
@endif

@include('dashboard.widgets.previews._members')
@include('dashboard.widgets.previews._relations')
@include('dashboard.widgets.previews._attributes')

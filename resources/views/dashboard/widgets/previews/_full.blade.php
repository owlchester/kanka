{!! $slot !!}

@if ($entity->hasEntry())
<div class="entity-content">
    {!! $entity->parsedEntry() !!}
</div>
@endif

@include('dashboard.widgets.previews._members')
@include('dashboard.widgets.previews._relations')
@include('dashboard.widgets.previews._attributes')

@if (!empty($entityData['timelineEras']))
## {!! __('timelines.fields.eras') !!}

@foreach ($entityData['timelineEras'] as $era)
### {!! html_entity_decode($era['name'], ENT_QUOTES, 'UTF-8') !!}@if (!empty($era['abbreviation'])) ({!! html_entity_decode($era['abbreviation'], ENT_QUOTES, 'UTF-8') !!})@endif
@if (!empty($era['ages']))
**{!! __('events.fields.date') !!}:** {!! $era['ages'] !!}
@endif
@if (!empty($era['entry']))
{!! $converter->convert((string) $era['entry']) !!}
@endif
@foreach ($era['elements'] as $element)
#### @if ($element['entity']){!! $element['entity'] !!}@else{!! html_entity_decode($element['name'], ENT_QUOTES, 'UTF-8') !!}@endif
@if (!empty($element['date']))
**{!! __('events.fields.date') !!}:** {!! html_entity_decode($element['date'], ENT_QUOTES, 'UTF-8') !!}
@endif
{!! $converter->convert((string) $element['entry']) !!}

@endforeach
@endforeach
@endif

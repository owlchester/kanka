## {!! __('entities.abilities') !!}

@foreach ($entityData['abilities'] as $group)
@if (count($entityData['abilities']) > 1)
### {!! $group['name'] !!}
@endif
@foreach ($group['abilities'] as $ability)
* **[{!! $ability['name'] !!}]({!! $ability['url'] !!})**
@if (!empty($ability['type']))
  * {!! $ability['type'] !!}
@endif
@if ($ability['charges'] !== null)
  * **{!! __('abilities.fields.charges') !!}:** {!! $ability['used_charges'] !!} / {!! $ability['charges'] !!}
@endif
@if (!empty($ability['entry']))
**{!! __('fields.description.label') !!}**
```
{!! trim($converter->convert((string) $ability['entry'])) !!}
```
@endif
@if (!empty($ability['note']))
**{!! __('entities/abilities.fields.note') !!}**
```
{!! trim($converter->convert((string) $ability['note'])) !!}
```
@endif
@endforeach
@endforeach

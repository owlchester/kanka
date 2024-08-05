<?php /**
 * @var \App\Models\Character $model
 * @var \App\Models\Entity $entity
 */?>
@if ($campaign->enabled('families') && !$model->characterFamilies->isEmpty())
@php
$existingFamilies = [];
$counter = 0;
@endphp
| {!! \App\Facades\Module::singular(config('entities.ids.family'), __('entities.families')) !!} | @foreach ($model->characterFamilies as $family) @if(!empty($existingFamilies[$family->family_id])) @continue @endif @php $existingRaces[$family->family_id] = true; @endphp {!! $family->family->name !!}@if ($counter < $model->characterFamilies->count() - 1)@php $counter++; @endphp, @endif @endforeach |
@endif
@if (!$model->characterRaces->isEmpty() || $model->hasAge())
@if (!$model->characterRaces->isEmpty() && !$model->hasAge())
@php
$existingRaces = [];
$counter = 0;
@endphp
| {!! \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')) !!} | @foreach ($model->characterRaces as $race) @if(!empty($existingRaces[$race->race_id])) @continue @endif @php $existingRaces[$race->race_id] = true; @endphp {!! $race->race->name !!}@if ($counter < $model->characterRaces->count() - 1)@php $counter++; @endphp, @endif @endforeach |
@elseif ($model->characterRaces->isEmpty() && $model->hasAge())
| {{ __('characters.fields.age') }} | {{ $model->age }} |
@else
@php
$existingRaces = [];
$counter = 0;
@endphp
| {!! \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')) !!} | @foreach ($model->characterRaces as $race) @if(!empty($existingRaces[$race->race_id])) @continue @endif @php $existingRaces[$race->race_id] = true; @endphp {!! $race->race->name !!}@if ($counter < $model->characterRaces->count() - 1)@php $counter++; @endphp, @endif @endforeach |
| {{ __('characters.fields.age') }} | {{ $model->age }} |
@endif
@endif
@if (!empty($model->sex) || !empty($model->pronouns))
@if (!empty($model->sex))
| {{ __('characters.fields.sex') }} | {{ $model->sex }} |
@endif
@if (!empty($model->pronouns))
| {{ __('characters.fields.pronouns') }} | {{ $model->pronouns }} |
@endif
@endif
@include('entities.pages.print.profile._events')
@include('entities.pages.print.profile._type')

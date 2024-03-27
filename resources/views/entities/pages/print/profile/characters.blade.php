<?php /**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 */?>
@if ($campaign->enabled('families') && !$model->families->isEmpty())
@php 
$existingFamilies = []; 
$counter = 0;
@endphp
| {!! \App\Facades\Module::singular(config('entities.ids.family'), __('entities.families')) !!} | @foreach ($model->families as $family) @if(!empty($existingFamilies[$family->id])) @continue @endif @php $existingRaces[$family->id] = true; @endphp {!! $family->name !!}@if ($counter < $model->families->count() - 1)@php $counter++; @endphp, @endif @endforeach |
@endif
@if (!$model->races->isEmpty() || $model->hasAge())
@if (!$model->races->isEmpty() && !$model->hasAge())
@php 
$existingRaces = []; 
$counter = 0;
@endphp
| {!! \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')) !!} | @foreach ($model->races as $race) @if(!empty($existingRaces[$race->id])) @continue @endif @php $existingRaces[$race->id] = true; @endphp {!! $race->name !!}@if ($counter < $model->races->count() - 1)@php $counter++; @endphp, @endif @endforeach |
@elseif ($model->races->isEmpty() && $model->hasAge())
| {{ __('characters.fields.age') }} | {{ $model->age }} |
@else
@php 
$existingRaces = []; 
$counter = 0;
@endphp
| {!! \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')) !!} | @foreach ($model->races as $race) @if(!empty($existingRaces[$race->id])) @continue @endif @php $existingRaces[$race->id] = true; @endphp {!! $race->name !!}@if ($counter < $model->races->count() - 1)@php $counter++; @endphp, @endif @endforeach |
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

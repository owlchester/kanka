<?php /**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 */?>
@if ($campaign->enabled('families') && !$model->families->isEmpty())
| {!! \App\Facades\Module::singular(config('entities.ids.family'), __('entities.families')) !!} | |
@php $existingFamilies = []; @endphp
@foreach ($model->families as $family)
@if(!empty($existingFamilies[$family->id]))
@continue
@endif
@php $existingRaces[$family->id] = true; @endphp
| | {!! $family->tooltipedLink() !!} |
@endforeach
@endif
@if (!$model->races->isEmpty() || $model->hasAge())
@if (!$model->races->isEmpty() && !$model->hasAge())
| {!! \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')) !!} | |
@php $existingRaces = []; @endphp
@foreach ($model->races as $race)
@if(!empty($existingRaces[$race->id]))
@continue
@endif
@php $existingRaces[$race->id] = true; @endphp
| | {!! $race->tooltipedLink() !!} |
@endforeach
@elseif ($model->races->isEmpty() && $model->hasAge())
| {{ __('characters.fields.age') }} | {{ $model->age }} |
@else
| {!! \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')) !!} | |
@php $existingRaces = []; @endphp
@foreach ($model->races as $race)
@if(!empty($existingRaces[$race->id]))
@continue
@endif
@php $existingRaces[$race->id] = true; @endphp
| | {!! $race->tooltipedLink() !!} |
@endforeach
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

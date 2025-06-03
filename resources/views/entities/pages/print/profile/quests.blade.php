<?php /** @var \App\Models\Quest $model */?>
@if (!empty($model->instigator))
| {{ __('quests.fields.instigator') }} | {!! $model->instigator->name !!} |
@endif
@if (!empty($model->location))
| {{ __('quests.fields.location') }} | {!! $model->location->name !!} |
@endif
@if ($model->date)
| {{ __('journals.fields.date') }} | <x-date :date="$model->date" string /> |
@endif
@include('entities.pages.print.profile._reminder')
@include('entities.pages.print.profile._type')

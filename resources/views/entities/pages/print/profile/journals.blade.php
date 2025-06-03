<?php /** @var \App\Models\Journal $model */?>
@include('entities.components.profile._location')
@if ($model->date)
| {{ __('journals.fields.date') }} | <x-date :date="$model->date" string /> |
@endif
@if ($model->author && $model->author)
| {{ __('journals.fields.author') }} | {!! $model->author->name !!} |
@endif
@include('entities.pages.print.profile._reminder')
@include('entities.pages.print.profile._type')

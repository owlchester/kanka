<?php /** @var \App\Models\Journal $model */?>
@include('entities.components.profile._location')
@if ($model->date)
| {{ __('journals.fields.date') }} | {{ \App\Facades\UserDate::format($model->date) }} |
@endif
@if ($model->author && $model->author)
| {{ __('journals.fields.author') }} | {!! $model->author->tooltipedLink() !!} |
@endif
@include('entities.pages.print.profile._reminder')
@include('entities.pages.print.profile._type')

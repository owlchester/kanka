<?php /** @var \App\Models\Tag $model */?>
@if (!empty($model->colour))
| {{ __('crud.fields.colour') }} | {{ $model->colour }} |
@endif
@include('entities.pages.print.profile._type')
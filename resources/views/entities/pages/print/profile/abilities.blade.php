<?php /** @var \App\Models\Ability $model */?>
@if (!empty($model->charges))
| {{ __('abilities.fields.charges') }} | {{ $model->charges }} |
@endif
@include('entities.pages.print.profile._type')
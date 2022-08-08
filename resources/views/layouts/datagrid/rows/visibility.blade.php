<?php /** @var \App\Traits\VisibilityIDTrait $model */ ?>
@if (auth()->check()) {!! $model->visibilityIcon() !!}@endif

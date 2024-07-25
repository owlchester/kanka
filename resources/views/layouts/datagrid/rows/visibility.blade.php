<?php /** @var \App\Traits\VisibilityIDTrait $model */ ?>
@includeWhen(auth()->check(), 'icons.visibility', ['icon' => $model->visibilityIcon()])

<?php /** @var \App\Traits\HasVisibility $model */ ?>
@includeWhen(auth()->check(), 'icons.visibility', ['icon' => $model->visibilityIcon()])

<?php /** @var \App\Models\Concerns\HasVisibility $model */ ?>
@includeWhen(auth()->check(), 'icons.visibility', ['icon' => $model->visibilityIcon()])

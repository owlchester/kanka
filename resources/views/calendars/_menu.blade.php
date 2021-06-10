<?php /** @var \App\Models\Calendar $model */ ?>
@inject('dateRenderer', 'App\Renderers\DateRenderer')


@includeWhen(!isset($exporting), 'entities.components.menu')
@includeWhen(auth()->check() && !isset($exporting), 'entities.components.actions')

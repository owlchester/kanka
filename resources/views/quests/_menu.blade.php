<?php /** @var \App\Models\Quest $model */?>
@includeWhen(!isset($exporting), 'entities.components.menu')
@includeWhen(!isset($exporting), 'entities.components.actions', ['disableMove' => true])

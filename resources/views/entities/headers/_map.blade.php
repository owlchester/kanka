<?php /**
 * @var \App\Models\Map $model
 */
?>
@includeWhen($model->parent, 'entities.headers.__parent', ['module' => 'map'])
@includeWhen($model->location, 'entities.headers.__location')



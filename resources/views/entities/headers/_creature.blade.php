<?php /**
 * @var \App\Models\Creature $model
 */
?>
@includeWhen($model->parent, 'entities.headers.__parent', ['module' => 'creature'])

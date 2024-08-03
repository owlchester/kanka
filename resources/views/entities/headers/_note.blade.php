<?php /**
 * @var \App\Models\Note $model
 */
?>
@includeWhen($model->parent, 'entities.headers.__parent', ['module' => 'note'])

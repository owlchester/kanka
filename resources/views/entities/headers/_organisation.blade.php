<?php /**
 * @var \App\Models\Organisation $model
 */
?>
@includeWhen($model->parent, 'entities.headers.__parent', ['module' => 'organisation'])

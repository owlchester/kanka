<?php /**
 * @var \App\Models\Timeline $model
 */
?>
@includeWhen($model->parent, 'entities.headers.__parent', ['module' => 'timeline'])

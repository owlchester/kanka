<?php /**
 * @var \App\Models\Family $model
 */
?>
@includeWhen($model->parent, 'entities.headers.__parent', ['module' => 'family'])
@include('entities.headers.__location')

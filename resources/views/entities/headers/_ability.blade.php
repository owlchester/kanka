<?php /**
 * @var \App\Models\Ability $model
 */
?>
@includeWhen($model->parent, 'entities.headers.__parent', ['module' => 'ability'])

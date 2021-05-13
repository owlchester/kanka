<?php

return [
    'actions'       => [
        'add'       => 'Nova nota de entidade',
        'add_user'  => 'Engadir usuaria',
    ],
    'create'        => [
        'description'   => 'Crear unha nova nota de entidade',
        'success'       => 'Nota de entidade ":name" engadida a :entity.',
        'title'         => 'Nova nota de entidade en :name',
    ],
    'destroy'       => [
        'success'   => 'Nota de entidade ":name" de :entity eliminada.',
    ],
    'edit'          => [
        'description'   => 'Actualizar unha nota de entidade existente.',
        'success'       => 'Nota de entidade ":name" de :entidade actualizada.',
        'title'         => 'Actualizar nota de entidade de :name',
    ],
    'fields'        => [
        'collapsed' => 'Pechar nota de entidade fixada por defecto.',
        'creator'   => 'Creadora',
        'entry'     => 'Entrada',
        'is_pinned' => 'Fixada',
        'name'      => 'Nome',
        'position'  => 'Posición fixada',
    ],
    'hint'          => 'Aquí podes poñer información que non encaixe nos campos estándar dunha entidade, ou que queras manter privada.',
    'hints'         => [
        'is_pinned' => 'As notas de entidade fixadas son mostradas debaixo do texto da entidade na súa vista principal. Usa o campo Posición para controlar a orde na que aparecen as notas fixadas.',
    ],
    'index'         => [
        'title' => 'Notas de entidade de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nome da nota de entidade, observación ou comentario.',
    ],
    'show'          => [
        'advanced'  => 'Permisos avanzados',
        'title'     => 'Nota de entidade ":name" de :entity',
    ],
];

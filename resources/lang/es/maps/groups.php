<?php

return [
    'actions'       => [
        'add'   => 'Añadir nuevo grupo',
    ],
    'create'        => [
        'success'   => 'Grupo :name creado.',
        'title'     => 'Nuevo grupo',
    ],
    'delete'        => [
        'success'   => 'Grupo :name eliminado.',
    ],
    'edit'          => [
        'success'   => 'Grupo :name actualizado.',
        'title'     => 'Editar grupo :name',
    ],
    'fields'        => [
        'is_shown'  => 'Mostrar marcadores del grupo',
        'position'  => 'Posición',
    ],
    'helper'        => [
        'amount'            => 'Incluir un marcador en un grupo permite mostrar o esconderlos todos a la vez (por ejemplo, mostrar o esconder todas las tiendas de una ciudad). Un mapa puede tener hasta :amount grupos.',
        'boosted_campaign'  => 'Las :boosted pueden tener hasta :amount grupos.',
    ],
    'hints'         => [
        'is_shown'  => 'Si está seleccionado, los marcadores del grupo se mostrarán en el mapa por defecto.',
    ],
    'placeholders'  => [
        'name'      => 'Tiendas, tesoros, PNJs...',
        'position'  => 'Campo opcional para indicar el orden en el que aparecen los grupos.',
    ],
];

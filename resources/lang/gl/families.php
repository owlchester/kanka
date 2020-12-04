<?php

return [
    'create'        => [
        'description'   => 'Crear unha nova familia',
        'success'       => 'Familia ":name" creada.',
        'title'         => 'Nova familia',
    ],
    'destroy'       => [
        'success'   => 'Familia ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Familia ":name" actualizada.',
        'title'     => 'Editar familia ":name"',
    ],
    'families'      => [
        'title' => 'Familias da familia ":name"',
    ],
    'fields'        => [
        'families'  => 'Subfamilias',
        'family'    => 'Familia superior',
        'image'     => 'Imaxe',
        'location'  => 'Localización',
        'members'   => 'Membras',
        'name'      => 'Nome',
        'relation'  => 'Relación',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contén todas as familias que son descendentes desta familia, non só as que están directamente relacionadas.',
        'nested'        => 'Na vista en árbore, podes ver as familias de forma agrupada. As familias sen ningunha familia superior serán mostradas primeiro. As que teñan subfamilias poden ser clicadas para explorar as súas descendentes.',
    ],
    'hints'         => [
        'members'   => 'As membras dunha familia móstranse aquí. Unha personaxe pode ser engadida a unha familia editando esa personaxe e usando o campo "Familia".',
    ],
    'index'         => [
        'add'           => 'Nova familia',
        'description'   => 'Administra as familias de ":name".',
        'header'        => 'Familias de ":name"',
        'title'         => 'Familias',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'A seguinte lista contén todas as personaxes que están nesta familia ou nalgunha das súas subfamilias.',
            'direct_members'    => 'Algunhas familias teñen membras que a lideron ou a fixeron famosa. Aquí móstranse as personaxes que están directamente nesta familia.',
        ],
        'title'     => 'Membras da familia ":name"',
    ],
    'placeholders'  => [
        'location'  => 'Elixe un lugar',
        'name'      => 'Nome da familia',
        'type'      => 'Real, nobre, extinta...',
    ],
    'show'          => [
        'description'   => 'Vista detallada dunha familia',
        'tabs'          => [
            'all_members'   => 'Todas as membras',
            'families'      => 'Familias',
            'members'       => 'Membras',
            'relation'      => 'Relacións',
        ],
        'title'         => 'Familia ":name"',
    ],
];

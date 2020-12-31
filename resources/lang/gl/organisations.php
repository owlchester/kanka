<?php

return [
    'create'        => [
        'description'   => 'Crear unha nova organización',
        'success'       => 'Organización ":name" creada.',
        'title'         => 'Nova organización',
    ],
    'destroy'       => [
        'success'   => 'Organización ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Organización ":name" actualizada.',
        'title'     => 'Editar organización ":name"',
    ],
    'fields'        => [
        'image'         => 'Imaxe',
        'location'      => 'Locación',
        'members'       => 'Integrantes',
        'name'          => 'Nome',
        'organisation'  => 'Organización superior',
        'organisations' => 'Suborganizacións',
        'relation'      => 'Relación',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contén todas as organizacións que son descendentes desta organización, non só as descendentes directas.',
        'nested'        => 'Na vista en árbore, podes ver as organizacións de forma agrupada. As organizacións sen ningunha organizzación superior serán mostradas por defecto. Podes facer clic nas organizacións con suborganizacións para explorar as súas descendentes.',
    ],
    'index'         => [
        'add'           => 'Nova organización',
        'description'   => 'Administra as organizacións de ":name".',
        'header'        => 'Organizacións de ":name"',
        'title'         => 'Organizacións',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Engadir integrante',
        ],
        'create'        => [
            'description'   => 'Engadir integrante á organización',
            'success'       => 'Integrante engadida á organización.',
            'title'         => 'Nova integrante de :name',
        ],
        'destroy'       => [
            'success'   => 'Integrante eliminada da organización.',
        ],
        'edit'          => [
            'success'   => 'Integrante da organización actualizada.',
            'title'     => 'Actualizar integrante de :name',
        ],
        'fields'        => [
            'character'     => 'Personaxe',
            'organisation'  => 'Organización',
            'role'          => 'Cargo',
        ],
        'helpers'       => [
            'all_members'   => 'Todas as personaxes que son integrantes desta organización ou das súas suborganizacións.',
            'members'       => 'Todas as personaxes integrantes desta organización.',
        ],
        'placeholders'  => [
            'character' => 'Elixe unha personaxe',
            'role'      => 'Líder, integrante, Septón supremo, Mestre de espías...',
        ],
        'title'         => 'Integrantes de :name',
    ],
    'organisations' => [
        'title' => 'Organizacións de :name',
    ],
    'placeholders'  => [
        'location'  => 'Elixe un lugar',
        'name'      => 'Nome da organización',
        'type'      => 'Culto, banda, rebelión, gremio...',
    ],
    'quests'        => [
        'description'   => 'Misións nas que participa a organización.',
        'title'         => 'Misións de :name',
    ],
    'show'          => [
        'description'   => 'Vista detallada dunha organización',
        'tabs'          => [
            'organisations' => 'Organizacións',
            'quests'        => 'Misións',
            'relations'     => 'Relacións',
        ],
        'title'         => 'Organización ":name"',
    ],
];

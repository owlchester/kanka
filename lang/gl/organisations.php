<?php

return [
    'create'        => [
        'title' => 'Nova organización',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_defunct'    => 'Extinta',
        'members'       => 'Integrantes',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_defunct'    => 'Esta organización está extinta.',
    ],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'add'       => 'Engadir integrante',
            'submit'    => 'Engadir integrante',
        ],
        'create'        => [
            'success'   => 'Integrante engadida á organización.',
            'title'     => 'Nova integrante de :name',
        ],
        'destroy'       => [
            'success'   => 'Integrante eliminada da organización.',
        ],
        'edit'          => [
            'success'   => 'Integrante da organización actualizada.',
            'title'     => 'Actualizar integrante de :name',
        ],
        'fields'        => [
            'parent'    => 'Superior',
            'pinned'    => 'Fixada',
            'role'      => 'Cargo',
            'status'    => 'Estado',
        ],
        'helpers'       => [
            'all_members'   => 'Todas as personaxes que son integrantes desta organización ou das súas suborganizacións.',
            'members'       => 'Todas as personaxes integrantes desta organización.',
            'pinned'        => 'Escolle se a pertenza a esta organización debería ser mostrada na sección de "Fixados" da correspondente entidade.',
        ],
        'pinned'        => [
            'both'  => 'En ambas',
            'none'  => 'En ningunha',
        ],
        'placeholders'  => [
            'parent'    => 'Quen é a superior desta integrante',
            'role'      => 'Líder, integrante, Septón supremo, Mestre de espías...',
        ],
        'status'        => [
            'active'    => 'En activo',
            'inactive'  => 'Inactivo',
            'unknown'   => 'Estado descoñecido',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Culto, banda, rebelión, gremio...',
    ],
    'quests'        => [],
    'show'          => [],
];

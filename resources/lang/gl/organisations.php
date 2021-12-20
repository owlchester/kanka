<?php

return [
    'create'        => [
        'success'   => 'Organización ":name" creada.',
        'title'     => 'Nova organización',
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
        'location'      => 'Localización',
        'members'       => 'Integrantes',
        'name'          => 'Nome',
        'organisation'  => 'Organización superior',
        'organisations' => 'Suborganizacións',
        'relation'      => 'Relación',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contén todas as organizacións que son descendentes desta organización, non só as descendentes directas.',
        'nested_parent' => 'Mostrando as organizacións de ":parent".',
        'nested_without'=> 'Mostrando todas as organizacións que non teñen unhas organización superior. Fai clic nunha fila para ver as súas descendentes.',
    ],
    'index'         => [
        'add'       => 'Nova organización',
        'header'    => 'Organizacións de ":name"',
        'title'     => 'Organizacións',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Engadir integrante',
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
    'quests'        => [],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organizacións',
            'quests'        => 'Misións',
            'relations'     => 'Relacións',
        ],
        'title' => 'Organización ":name"',
    ],
];

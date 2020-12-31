<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Engadir unha personaxe á misión',
            'success'       => 'Personaxe engadida a ":name".',
            'title'         => 'Nova personaxe para ":name"',
        ],
        'destroy'   => [
            'success'   => 'Personaxe eliminada da misión ":name".',
        ],
        'edit'      => [
            'description'   => 'Actualizar a personaxe da misión',
            'success'       => 'Personaxe da misión ":name" actualizada.',
            'title'         => 'Actualizar personaxe de ":name"',
        ],
        'fields'    => [
            'character'     => 'Personaxe',
            'description'   => 'Descrición',
        ],
        'title'     => 'Personaxes en ":name"',
    ],
    'create'        => [
        'description'   => 'Crear unha nova misión',
        'success'       => 'Misión ":name" creada.',
        'title'         => 'Nova misión',
    ],
    'destroy'       => [
        'success'   => 'Misión ":name" eliminada.',
    ],
    'edit'          => [
        'description'   => 'Editar unha misión',
        'success'       => 'Misión ":name" actualizada.',
        'title'         => 'Editar misión ":name"',
    ],
    'fields'        => [
        'character'     => 'Quen deu a misión',
        'characters'    => 'Personaxes',
        'copy_elements' => 'Copiar elementos ligados á misión',
        'date'          => 'Data',
        'description'   => 'Descrición',
        'image'         => 'Imaxe',
        'is_completed'  => 'Completada',
        'items'         => 'Obxetos',
        'locations'     => 'Lugares',
        'name'          => 'Nome',
        'organisations' => 'Organizacións',
        'quest'         => 'Misión superior',
        'quests'        => 'Submisións',
        'role'          => 'Rol',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'Na vista en árbore, podes ver as misións de forma agruada. As misións sen ningunha misión superior serán mostradas por defecto. Podes facer clic nas misións con submisións para explorar as súas descendentes.',
    ],
    'hints'         => [
        'quests'    => 'Podes crear unha rede de misións entrelazadas usando o campo "Misión superior".',
    ],
    'index'         => [
        'add'           => 'Nova misión',
        'description'   => 'Administra as misións de ":name".',
        'header'        => 'Misións de ":name"',
        'title'         => 'Misións',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Engadir un obxeto á misión',
            'success'       => 'Obxeto engadido a ":name"',
            'title'         => 'Novo obxeto para ":name"',
        ],
        'destroy'   => [
            'success'   => 'Obxeto eliminado da misión ":name".',
        ],
        'edit'      => [
            'description'   => 'Actualiza un obxeto da misión',
            'success'       => 'Obxeto actualizado na misión ":name".',
            'title'         => 'Actualizar obxeto en ":name"',
        ],
        'fields'    => [
            'description'   => 'Descrición',
            'item'          => 'Obxeto',
        ],
        'title'     => 'Obxetos en ":name"',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Establece un lugar para a misión',
            'success'       => 'Lugar engadido a ":name".',
            'title'         => 'Novo lugar para ":name"',
        ],
        'destroy'   => [
            'success'   => 'Lugar eliminado da misión ":name".',
        ],
        'edit'      => [
            'description'   => 'Actualiza un lugar da misión',
            'success'       => 'Lugar actualizado na misión ":name".',
            'title'         => 'Actualizar lugar de ":name"',
        ],
        'fields'    => [
            'description'   => 'Descrición',
            'location'      => 'Lugar',
        ],
        'title'     => 'Lugares en ":name"',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Engade unha organización á misión',
            'success'       => 'Organización engadida a ":name".',
            'title'         => 'Nova organización para ":name"',
        ],
        'destroy'   => [
            'success'   => 'Organización eliminada da misión ":name".',
        ],
        'edit'      => [
            'description'   => 'Actualiza unha organización da misión',
            'success'       => 'Organización actualizada na misión ":name".',
            'title'         => 'Actualizar organización en ":name"',
        ],
        'fields'    => [
            'description'   => 'Descrición',
            'organisation'  => 'Organización',
        ],
        'title'     => 'Organizacións en ":name"',
    ],
    'placeholders'  => [
        'date'  => 'Data do mundo real para a misión',
        'name'  => 'Nome da misión',
        'quest' => 'Misión superior',
        'role'  => 'O rol desta entidade na misión',
        'type'  => 'Arco de personaxe, Misión secundaria, Historia principal...',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Engadir personaxe',
            'add_item'          => 'Engadir obxeto',
            'add_location'      => 'Engadir lugar',
            'add_organisation'  => 'Engadir organización',
        ],
        'description'   => 'Vista detallada dunha misión',
        'tabs'          => [
            'characters'    => 'Personaxes',
            'information'   => 'Información',
            'items'         => 'Obxetos',
            'locations'     => 'Lugares',
            'organisations' => 'Organizacións',
            'quests'        => 'Misións',
        ],
        'title'         => 'Misión ":name"',
    ],
];

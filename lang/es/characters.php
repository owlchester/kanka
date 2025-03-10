<?php

return [
    'actions'       => [
        'add_appearance'    => 'Añadir apariencia',
        'add_personality'   => 'Añadir personalidad',
    ],
    'conversations' => [],
    'create'        => [
        'title' => 'Nuevo Personaje',
    ],
    'destroy'       => [],
    'dice_rolls'    => [],
    'edit'          => [],
    'families'      => [
        'reorder'   => [
            'success'   => 'Las familias del personaje se han actualizado correctamente.',
        ],
        'title'     => 'Administrar familias de :name',
    ],
    'fields'        => [
        'age'                       => 'Edad',
        'is_appearance_pinned'      => 'Apariencia fijada',
        'is_dead'                   => 'Muerto',
        'is_personality_pinned'     => 'Personalidad fijada',
        'is_personality_visible'    => 'Personalidad visible',
        'life'                      => 'Biografía',
        'physical'                  => 'Apariencia',
        'pronouns'                  => 'Pronombres',
        'sex'                       => 'Género',
        'title'                     => 'Título',
        'traits'                    => 'Características',
    ],
    'helpers'       => [
        'age'   => 'Puedes vincular esta entidad con un calendario de la campaña para calcular automáticamente su edad. :more',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Si está seleccionado, la apariencia del personaje aparecerá bajo la entrada principal de la página.',
        'is_dead'                   => 'Este personaje está muerto',
        'is_personality_pinned'     => 'Si está seleccionado, los rasgos de personalidad del personaje aparecerán bajo la entrada principal en la página.',
        'is_personality_visible'    => 'Se puede ocultar la sección de personalidad a los usuarios no administradores.',
        'personality_not_visible'   => 'Los rasgos de personalidad de este personaje actualmente solo son visibles para los administradores.',
        'personality_visible'       => 'Los rasgos de personalidad de este personaje son visibles para todos.',
    ],
    'index'         => [],
    'items'         => [],
    'journals'      => [],
    'labels'        => [
        'appearance'    => [
            'entry' => 'Descripción de la apariencia',
            'name'  => 'Nombre de la apariencia',
        ],
        'personality'   => [
            'entry' => 'Descripción del rasgo de personalidad',
            'name'  => 'Nombre del rasgo de personalidad',
        ],
    ],
    'maps'          => [],
    'organisations' => [
        'create'    => [
            'success'   => 'Personaje añadido a la organización.',
            'title'     => 'Nueva organización para :name',
        ],
        'destroy'   => [
            'success'   => 'Personaje quitado de la organización.',
        ],
        'edit'      => [
            'success'   => 'Organización del personaje actualizada.',
            'title'     => 'Actualizar organización de :name',
        ],
        'fields'    => [
            'role'  => 'Rol',
        ],
    ],
    'placeholders'  => [
        'age'               => 'Edad',
        'appearance_entry'  => 'Descripción',
        'appearance_name'   => 'Cabello, ojos, piel, altura...',
        'name'              => 'Nombre del personaje',
        'personality_entry' => 'Detalles',
        'personality_name'  => 'Objetivos, manías, miedos, lazos...',
        'physical'          => 'Físico',
        'pronouns'          => 'Él, ella, elle',
        'sex'               => 'Género',
        'title'             => 'Título',
        'traits'            => 'Características',
        'type'              => 'PNJ, Personaje Jugador, divinidad...',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Misiones que el personaje ha promovido.',
            'quest_member'  => 'Misiones de las que el personaje es miembro.',
        ],
    ],
    'races'         => [
        'reorder'   => [
            'success'   => 'Razas del personaje actualizadas correctamente',
        ],
        'title'     => 'Administrar las razas de :name',
    ],
    'sections'      => [
        'appearance'    => 'Apariencia',
        'personality'   => 'Personalidad',
    ],
    'show'          => [],
    'warnings'      => [
        'personality_hidden'    => 'No puedes editar los rasgos de personalidad de este personaje.',
    ],
];

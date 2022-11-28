<?php

return [
    'actions'       => [
        'add_appearance'    => 'Engadir aparencia',
        'add_organisation'  => 'Engadir unha organización',
        'add_personality'   => 'Engadir personalidade',
    ],
    'conversations' => [
        'title' => 'Conversas de :name',
    ],
    'create'        => [
        'title' => 'Nova personaxe',
    ],
    'destroy'       => [],
    'dice_rolls'    => [
        'hint'  => 'Pódense asignar tiradas de dados a unha personaxe para usalas no xogo.',
        'title' => 'Tiradas de dados de :name',
    ],
    'edit'          => [],
    'fields'        => [
        'age'                       => 'Idade',
        'families'                  => 'Familias',
        'is_appearance_pinned'      => 'Aparencia fixada',
        'is_dead'                   => 'Morta',
        'is_personality_pinned'     => 'Personalidade fixada',
        'is_personality_visible'    => 'Personalidade visible',
        'life'                      => 'Biografía',
        'physical'                  => 'Físico',
        'pronouns'                  => 'Terminacións/pronomes',
        'sex'                       => 'Xénero',
        'title'                     => 'Título',
        'traits'                    => 'Trazos de personalidade',
    ],
    'helpers'       => [
        'age'   => 'Podes vincular esta entidade cun calendario da campaña para que a súa idade sexa calculada automáticamente. :more.',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Se está seleccionado, a aparencia da personaxe aparecerá fixada na páxina principal da entidade.',
        'is_dead'                   => 'Esta personaxe está morta',
        'is_personality_pinned'     => 'Se está seleccionado, os trazos de personalidade da personaxe aparecerán fixados na páxina principal da entidade.',
        'is_personality_visible'    => 'Desmarca esta opción para que a sección de personalidade só sexa visible para a administración da campaña.',
        'personality_not_visible'   => 'Os trazos de personalidade desta personaxe actualmente só son visibles para a administración da campaña.',
        'personality_visible'       => 'Os trazos de personalidade desta personaxe son visibles para todo o mundo.',
    ],
    'index'         => [],
    'items'         => [
        'hint'  => 'Os obxectos asignados a personaxes serán mostrados aquí.',
        'title' => 'Obxectos de :name',
    ],
    'journals'      => [
        'title' => 'Cadernos de :name',
    ],
    'maps'          => [
        'title' => 'Mapa de relacións de :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Engadir organización',
        ],
        'create'        => [
            'success'   => 'Personaxe engadida á organización.',
            'title'     => 'Nova organización para :name',
        ],
        'destroy'       => [
            'success'   => 'Organización da personaxe eliminada.',
        ],
        'edit'          => [
            'success'   => 'Organización da personaxe actualizada.',
            'title'     => 'Actualizar a organización de :name',
        ],
        'fields'        => [
            'organisation'  => 'Organización',
            'role'          => 'Cargo',
        ],
        'hint'          => 'As personaxes poden ser parte de varias organizacións, representando para quen traballan ou de que sociedade segreda son parte.',
        'placeholders'  => [
            'organisation'  => 'Elixe unha organización...',
        ],
        'title'         => 'Organizacións de :name',
    ],
    'placeholders'  => [
        'age'               => 'Idade',
        'appearance_entry'  => 'Descrición',
        'appearance_name'   => 'Cabelo, ollos, pel, altura...',
        'personality_entry' => 'Detalles',
        'personality_name'  => 'Obxectivos, manerismos, medos, vínculos...',
        'physical'          => 'Físico',
        'pronouns'          => '-a/ela, -o/el, -e/elu...',
        'sex'               => 'Xénero',
        'title'             => 'Título',
        'traits'            => 'Trazos de personalidade',
        'type'              => 'PNX, Personaxe Xogadora, deidade...',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Misións que promoveu a personaxe.',
            'quest_member'  => 'Misións nas que participa a personaxe.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Aparencia',
        'general'       => 'Información xeral',
        'personality'   => 'Personalidade',
    ],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organizacións',
        ],
    ],
    'warnings'      => [
        'personality_hidden'    => 'Non tes permiso para editar os trazos de presonalidade desta personaxe.',
    ],
];

<?php

return [
    'actions'       => [
        'add_appearance'    => 'Engadir aparencia',
        'add_organisation'  => 'Engadir unha organización',
        'add_personality'   => 'Engadir personalidade',
    ],
    'conversations' => [
        'description'   => 'Conversas nas que a personaxe participa.',
        'title'         => 'Conversas de :name',
    ],
    'create'        => [
        'description'   => 'Crear unha nova personaxe',
        'success'       => 'Personaxe ":name" creada.',
        'title'         => 'Nova personaxe',
    ],
    'destroy'       => [
        'success'   => 'Personaxe ":name" eliminada.',
    ],
    'dice_rolls'    => [
        'description'   => 'Tiradas de dados asignadas á personaxe.',
        'hint'          => 'Pódense asignar tiradas de dados a unha personaxe para usalas no xogo.',
        'title'         => 'Tiradas de dados de :name',
    ],
    'edit'          => [
        'description'   => 'Editar unha personaxe',
        'success'       => 'Personaxe ":name" actualizada.',
        'title'         => 'Editar personaxe ":name"',
    ],
    'fields'        => [
        'age'                       => 'Idade',
        'family'                    => 'Familia',
        'image'                     => 'Imaxe',
        'is_dead'                   => 'Morta',
        'is_personality_visible'    => 'Personalidade visíbel',
        'life'                      => 'Biografía',
        'location'                  => 'Localización',
        'name'                      => 'Nome',
        'physical'                  => 'Físico',
        'race'                      => 'Raza',
        'relation'                  => 'Relación',
        'sex'                       => 'Xénero',
        'title'                     => 'Título',
        'traits'                    => 'Trazos de personalidade',
        'type'                      => 'Tipo',
    ],
    'helpers'       => [
        'age'   => 'Podes vincular esta entidade cun calendario da campaña para que a súa idade sexa calculada automáticamente. :more.',
    ],
    'hints'         => [
        'is_dead'                   => 'Esta personaxe está morta',
        'is_personality_visible'    => 'Desmarca esta opción para que a sección de personalidade só sexa visíbel para a administración da campaña.',
        'personality_not_visible'   => 'Os trazos de personalidade desta personaxe actualmente só son visíbeis para a administración da campaña.',
        'personality_visible'       => 'Os trazos de personalidade desta personaxe son visíbeis para todo o mundo.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Nova personaxe aleatoria',
        ],
        'add'           => 'Nova personaxe',
        'description'   => 'Administra as personaxes de ":name"',
        'header'        => 'Personaxes de ":name"',
        'title'         => 'Personaxes',
    ],
    'items'         => [
        'description'   => 'Obxetos que ten a personaxe.',
        'hint'          => 'Os obxetos asignados a personaxes serán mostrados aquí.',
        'title'         => 'Obxetos de :name',
    ],
    'journals'      => [
        'description'   => 'Cadernos da autoría desta personaxe.',
        'title'         => 'Cadernos de :name',
    ],
    'maps'          => [
        'description'   => 'Mapa de relacións dunha personaxe.',
        'title'         => 'Mapa de relacións de :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Engadir organización',
        ],
        'create'        => [
            'description'   => 'Asocia unha organización a unha personaxe',
            'success'       => 'Personaxe engadida á organización.',
            'title'         => 'Nova organización para :name',
        ],
        'description'   => 'Organizacións das que a personaxe é parte.',
        'destroy'       => [
            'success'   => 'Organización da personaxe eliminada.',
        ],
        'edit'          => [
            'description'   => 'Actualiza a organización dunha personaxe',
            'success'       => 'Organización da personaxe actualizada.',
            'title'         => 'Actualizar a organización de :name',
        ],
        'fields'        => [
            'organisation'  => 'Organización',
            'role'          => 'Cargo',
        ],
        'hint'          => 'As personaxes poden ser parte de varias organizacións, representando para quen traballan ou de que sociedade secreta son parte.',
        'placeholders'  => [
            'organisation'  => 'Elixe unha organización...',
        ],
        'title'         => 'Organizacións de :name',
    ],
    'placeholders'  => [
        'age'               => 'Idade',
        'appearance_entry'  => 'Descrición',
        'appearance_name'   => 'Cabelo, ollos, pel, altura...',
        'family'            => 'Selecciona unha personaxe',
        'image'             => 'Imaxe',
        'location'          => 'Selecciona un lugar',
        'name'              => 'Nome',
        'personality_entry' => 'Detalles',
        'personality_name'  => 'Obxetivos, manerismos, medos, vínculos...',
        'physical'          => 'Físico',
        'race'              => 'Raza',
        'sex'               => 'Xénero',
        'title'             => 'Título',
        'traits'            => 'Trazos de personalidade',
        'type'              => 'PNX, Personaxe Xogadora, deidade...',
    ],
    'quests'        => [
        'description'   => 'Misións das que é parte a personaxe.',
        'helpers'       => [
            'quest_giver'   => 'Misións que promoveu a personaxe.',
            'quest_member'  => 'Misións nas que participa a personaxe.',
        ],
        'title'         => 'Misións de :name',
    ],
    'sections'      => [
        'appearance'    => 'Aparencia',
        'general'       => 'Información xeral',
        'personality'   => 'Personalidade',
    ],
    'show'          => [
        'description'   => 'Vista detallada dunha personaxe',
        'tabs'          => [
            'conversations' => 'Conversas',
            'dice_rolls'    => 'Tiradas de dados',
            'items'         => 'Obxetos',
            'journals'      => 'Cadernos',
            'map'           => 'Mapa de relacións',
            'organisations' => 'Organizacións',
            'personality'   => 'Personalidade',
            'quests'        => 'Misións',
        ],
        'title'         => 'Personaxe ":name"',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Non tes permiso para editar os trazos de presonalidade desta personaxe.',
    ],
];

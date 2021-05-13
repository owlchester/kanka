<?php

return [
    'actions'   => [
        'add'               => 'Engadir habilidades',
        'import_from_race'  => 'Engadir habilidades de raza',
        'reset'             => 'Restablecer número de usos de habilidade',
    ],
    'create'    => [
        'success'           => 'Habilidade ":ability" engadida a :entity.',
        'success_multiple'  => 'Habilidades ":abilities" engadidas a :entity.',
        'title'             => 'Engadir habilidades a :name',
    ],
    'fields'    => [
        'note'      => 'Nota',
        'position'  => 'Posición',
    ],
    'helpers'   => [
        'note'  => 'Podes referenciar entidades usando mencións avanzadas (exemplo: :code) e atributos da entidade (exemplo: :attr) neste campo.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'A personaxe non ten raza.',
            'not_character' => 'A entidade non é unha personaxe.',
        ],
        'success'   => '{1} :count habilidade importada.|[2,*] :count habilidades importadas.',
    ],
    'show'      => [
        'helper'    => 'Engade habilidades a esta entidade. Sempre podes editar a visibilidade ou eliminar unha habilidade. As habilidades pertencentes á mesma habilidade nai serán mostradas como caixas de filtro.',
        'title'     => 'Habilidades de :name',
    ],
    'update'    => [
        'title' => 'Habilidade de :name',
    ],
];

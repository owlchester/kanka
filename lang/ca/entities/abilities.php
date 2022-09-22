<?php

return [
    'actions'   => [
        'add'                       => 'Afegeix una habilitat',
        'import_from_race'          => 'Afegeix habilitats de raça',
        'import_from_race_mobile'   => 'Habilitats racials',
        'reset'                     => 'Restableix els usos de l\'habilitat',
    ],
    'create'    => [
        'success'           => 'S\'ha afegit l\'habilitat :ability a :entity.',
        'success_multiple'  => 'S\'han afegit les habilitats :abilities a :entity.',
        'title'             => 'Afegeix una habilitat a :name',
    ],
    'fields'    => [
        'note'      => 'Nota',
        'position'  => 'Posició',
    ],
    'helpers'   => [
        'note'  => 'Podeu referenciar entitats mitjançant les mencions avançades (per exemple, :code) i els atributs de les entitats (ex., :attr) dins d\'aquest camp.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'El personatge no té cap raça.',
            'not_character' => 'L\'entitat no és un personatge.',
        ],
        'success'   => '{1} S\'ha importat :count habilitat.|[2,*] S\'han importat :count habilitats.',
    ],
    'show'      => [
        'helper'    => 'Adjunta habilitats a aquesta entitat. Se\'n pot modificar la visibilitat o eliminar-les més endavant. Les habilitats que pertanyen al mateix grup s\'agrupen per tipus.',
        'title'     => 'Habilitats de :name',
    ],
    'update'    => [
        'title' => 'Habilitat de :name',
    ],
];

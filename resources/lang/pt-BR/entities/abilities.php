<?php

return [
    'actions'   => [
        'add'               => 'Adicionar uma habilidade',
        'import_from_race'  => 'Adicionar habilidades de raça',
        'reset'             => 'Redefinir número de usos da habilidade',
    ],
    'create'    => [
        'success'           => 'Habilidade :ability adicionada a :entity',
        'success_multiple'  => 'Habilidades :abilities adicionadas a entidade.',
        'title'             => 'Adicionar habilidade a :name',
    ],
    'fields'    => [
        'note'      => 'Nota',
        'position'  => 'Posição',
    ],
    'helpers'   => [
        'note'  => 'Você pode fazer referência a entidades usando as menções avançadas (ex :code) e atributos da entidade (ex :attr) nesse campo.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'O personagem não possui raça.',
            'not_character' => 'A entidade não é um personagem.',
        ],
        'success'   => '{1} :count habilidade importada.|[2,*] :count habilidades importadas.',
    ],
    'show'      => [
        'helper'    => 'Adicione habilidades a esta entidade. Você sempre pode editar a visibilidade ou remover uma habilidade. Habilidades pertencentes à mesma habilidade principal serão exibidas como caixas de filtro.',
        'title'     => 'Habilidades de :name',
    ],
    'update'    => [
        'title' => 'Habilidade de Entidade para :name',
    ],
];

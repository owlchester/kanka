<?php

return [
    'actions'   => [
        'add'                       => 'Add habilidades',
        'import_from_race'          => 'Add habilidades de raça',
        'import_from_race_mobile'   => 'Habilidades de raça',
        'reset'                     => 'Redefinir usos da habilidade',
    ],
    'create'    => [
        'success'           => 'Habilidade :ability adicionada a :entity.',
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
    'reorder'   => [
        'parentless'    => 'Sem Pai',
        'success'       => 'Habilidades reordenadas com sucesso',
        'title'         => 'Reordenar as habilidades',
    ],
    'show'      => [
        'helper'    => 'Adicione habilidades a esta entidade. Você sempre pode editar a visibilidade ou remover uma habilidade. Habilidades pertencentes à mesma habilidade primária serão exibidas como caixas de filtro.',
        'reorder'   => 'Reordenar Habilidades',
        'title'     => 'Habilidades de :name',
    ],
    'update'    => [
        'title' => 'Habilidade de Entidade para :name',
    ],
];

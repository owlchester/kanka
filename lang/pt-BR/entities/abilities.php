<?php

return [
    'actions'   => [
        'add'   => 'Adicionar habilidades',
        'reset' => 'Redefinir usos da habilidade',
        'sync'  => 'Adicionar das raças',
    ],
    'charges'   => [
        'left'  => ':amount sobrando',
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
    'groups'    => [
        'unorganised'   => 'Desorganizado',
    ],
    'helpers'   => [
        'note'      => 'Você pode fazer referência a entidades usando as menções avançadas (ex :code) e atributos da entidade (ex :attr) nesse campo.',
        'recharge'  => 'Redefina todas as cargas de habilidades que foram usadas.',
        'sync'      => 'Importe habilidades definidas nas raças do personagem.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'O personagem não possui raça.',
            'not_character' => 'A entidade não é um personagem.',
        ],
        'success'   => '{1} :count habilidade importada.|[2,*] :count habilidades importadas.',
    ],
    'recharge'  => [
        'success'   => 'Todas as cargas foram redefinidas.',
    ],
    'reorder'   => [
        'parentless'    => 'Sem Pai',
        'success'       => 'Habilidades reordenadas com sucesso',
    ],
    'show'      => [
        'helper'    => 'Adicione habilidades a esta entidade. Você sempre pode editar a visibilidade ou remover uma habilidade. Habilidades pertencentes à mesma habilidade primária serão exibidas como caixas de filtro.',
        'reorder'   => 'Reordenar Habilidades',
        'title'     => 'Habilidades de :name',
    ],
    'update'    => [
        'success'   => 'Habilidade :ability da entidade atualizada.',
        'title'     => 'Habilidade de Entidade para :name',
    ],
];

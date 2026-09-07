<?php

return [
    'actions'   => [
        'add'   => 'Adicionar habilidades',
        'reset' => 'Recarregar',
        'sync'  => 'Adicionar das raças',
    ],
    'charges'   => [
        'left'  => ':amount sobrando',
    ],
    'create'    => [
        'helper'            => 'Anexar uma das diversas habilidades a :name.',
        'success'           => 'Habilidade :ability adicionada a :entity.',
        'success_multiple'  => 'Habilidades :abilities adicionadas a entidade.',
        'title'             => 'Adicionar habilidades',
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
        'errors'            => [
            'no_race'       => 'O personagem não possui raça.',
            'not_character' => 'A entidade não é um personagem.',
        ],
        'helper'            => 'Anexe habilidades das seguintes raças :name que pertencem a:',
        'no_abilities'      => 'Atualmente, não há recursos para importar das raças às quais :name pertence.',
        'race_abilities'    => '{1} :name (:count habilidade)|[2,*] :name (:count habilidades)',
        'success'           => '{1} :count habilidade importada.|[2,*] :count habilidades importadas.',
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
        'reorder'   => 'Reordenar',
        'title'     => 'Habilidades de :name',
    ],
    'types'     => [
        'unorganised'   => 'As habilidades são agrupadas pelo campo pai e retornam para cá.',
    ],
    'update'    => [
        'success'   => 'Habilidade :ability da entidade atualizada.',
        'title'     => 'Habilidade de Entidade para :name',
    ],
];

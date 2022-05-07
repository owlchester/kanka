<?php

return [
    'actions'       => [
        'mode-map'      => 'Ferramenta de exploração das relações',
        'mode-table'    => 'Tabela de relações e conexões',
    ],
    'bulk'          => [
        'delete'    => '{1} :count relação deletada. |[2,*] :count relações deletadas.',
        'success'   => [
            'editing'           => '{1} :count relação foi atualizada. |[2,*] :count relações foram atualizadas.',
            'editing_partial'   => '{1} :count/:total relação foi atualizada. |[2,*] :count/:total relações foram atualizadas.',
        ],
    ],
    'connections'   => [
        'map_point'         => 'Ponto do mapa',
        'mention'           => 'Menção',
        'quest_element'     => 'Elemento da missão',
        'timeline_element'  => 'Elemento da linha do tempo',
    ],
    'create'        => [
        'new_title' => 'Nova relação',
        'success'   => 'Relação adicionada para :name.',
        'title'     => 'Criar relações',
    ],
    'destroy'       => [
        'success'   => 'Relação de :name removida.',
    ],
    'fields'        => [
        'attitude'          => 'Atitude',
        'connection'        => 'Conexão',
        'is_star'           => 'Fixado',
        'owner'             => 'Fonte',
        'relation'          => 'Relação',
        'target'            => 'Alvo',
        'target_relation'   => 'Relação Alvo',
        'two_way'           => 'Criar relação mútua',
    ],
    'helper'        => 'Estabeleça relações entre entidades com atitudes e visibilidade. Relações também podem ser fixadas no menu da entidade.',
    'hints'         => [
        'attitude'          => 'Este campo opcional pode ser usado para definir a ordem na qual as relações aparecem, em ordem decrescente.',
        'mirrored'          => [
            'text'  => 'Esta relação é espelhada com :link',
            'title' => 'Espelhada',
        ],
        'target_relation'   => 'A descrição da relação do alvo. Deixe em branco para usar esse texto da relação.',
        'two_way'           => 'Se você selecionar para criar relação mútua, a mesma relação será criada no alvo. Entretanto, se você editar uma, a outra não será atualizada.',
    ],
    'index'         => [
        'title' => 'Relações',
    ],
    'options'       => [
        'mentions'  => 'Relações + relacionados + menções',
        'related'   => 'Relações + relacionados',
        'relations' => 'Relações',
        'show'      => 'Mostrar',
    ],
    'panels'        => [
        'related'   => 'Relacionados',
    ],
    'placeholders'  => [
        'attitude'  => 'De -100 a100, com 100 sendo muito positiva',
        'relation'  => 'Natureza da relação',
        'target'    => 'Escolha uma entidade',
    ],
    'show'          => [
        'title' => 'Relações de :name',
    ],
    'teaser'        => 'Impulsione a campanha para ter acesso ao explorador de relações. Clique para saber mais sobre campanhas impulsionadas.',
    'types'         => [
        'family_member'         => 'Membro da família',
        'organisation_member'   => 'Membro da organização',
    ],
    'update'        => [
        'success'   => 'Relação de :name atualizada.',
        'title'     => 'Atualizar relações',
    ],
];

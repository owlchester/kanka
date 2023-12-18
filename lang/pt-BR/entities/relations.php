<?php

return [
    'actions'           => [
        'mode-map'      => 'Ferramenta de exploração das relações',
        'mode-table'    => 'Tabela de relações e conexões',
    ],
    'bulk'              => [
        'delete'    => '{1} :count relação removida. |[2,*] :count relações removidas.',
        'fields'    => [
            'delete_mirrored'   => 'Excluir espelhado',
            'unmirror'          => 'Desvincular espelhado',
            'update_mirrored'   => 'Atualizar espelhado',
        ],
        'helpers'   => [
            'delete_mirrored'   => 'Exclua também as conexões espelhadas.',
            'unmirror'          => 'Desvincula conexões espelhadas.',
            'update_mirrored'   => 'Atualiza conexões espelhadas.',
        ],
        'success'   => [
            'editing'           => '{1} :count relação foi atualizada. |[2,*] :count relações foram atualizadas.',
            'editing_partial'   => '{1} :count/:total relação foi atualizada. |[2,*] :count/:total relações foram atualizadas.',
        ],
    ],
    'call-to-action'    => 'Explore visualmente as relações dessa entidade e como ela está conectada ao restante da campanha.',
    'connections'       => [
        'map_point'         => 'Ponto do mapa',
        'mention'           => 'Menção',
        'quest_element'     => 'Elemento da missão',
        'timeline_element'  => 'Elemento da linha do tempo',
    ],
    'create'            => [
        'new_title' => 'Nova relação',
        'success'   => 'Relação :target adicionada para :entity.',
        'title'     => 'Nova relação para :name',
    ],
    'delete_mirrored'   => [
        'helper'    => 'Essa relação está espelhada na entidade alvo. Selecione essa opção para também remover  a relação espelhada.',
        'option'    => 'Remover relação espelhada',
    ],
    'destroy'           => [
        'mirrored'  => 'Isso também removerá a relação espelhada e é permanente.',
        'success'   => 'Relação de :target removida para :entity.',
    ],
    'fields'            => [
        'attitude'          => 'Atitude',
        'connection'        => 'Conexão',
        'is_pinned'         => 'Fixado',
        'is_star'           => 'Fixado',
        'owner'             => 'Fonte',
        'relation'          => 'Relação',
        'target'            => 'Alvo',
        'target_relation'   => 'Relação Alvo',
        'two_way'           => 'Criar relação mútua',
        'unmirror'          => 'Desespelhe esta relação.',
    ],
    'helper'            => 'Estabeleça relações entre entidades com atitudes e visibilidade. Relações também podem ser fixadas no menu da entidade.',
    'helpers'           => [
        'no_relations'  => 'Essa entidade atualmente não tem quaisquer outras relações com outras entidades da campanha.',
        'popup'         => 'Entidades da campanha podem ser vinculadas umas às outras usando relações. Elas podem ter uma descrição, uma avaliação de atitude, uma visibilidade para controlar quem vê a relação, e muito mais.',
    ],
    'hints'             => [
        'attitude'          => 'Este campo opcional pode ser usado para definir as relações de ordem padrão exibidas em ordem decrescente.',
        'mirrored'          => [
            'text'  => 'Esta relação é espelhada com :link',
            'title' => 'Espelhada',
        ],
        'target_relation'   => 'A descrição da relação com o alvo. Deixe em branco para usar o texto desta relação.',
        'two_way'           => 'Se você selecionar para criar relação mútua, a mesma relação será criada no alvo. Entretanto, se você editar uma, a outra não será atualizada.',
    ],
    'index'             => [
        'title' => 'Relações',
    ],
    'options'           => [
        'mentions'          => 'Padrão + relacionados + menções',
        'only_relations'    => 'Apenas relações diretas',
        'related'           => 'Padrão + relacionados',
        'relations'         => 'Padrão',
        'show'              => 'Mostrar',
    ],
    'panels'            => [
        'related'   => 'Relacionados',
    ],
    'placeholders'      => [
        'attitude'          => '-100 a 100, 100 sendo muito positiva',
        'relation'          => 'Rival, Melhor Amigo, Irmão',
        'target'            => 'Escolha uma entidade',
        'target_relation'   => 'Deixe em branco para usar a descrição',
    ],
    'show'              => [
        'title' => 'Relações de :name',
    ],
    'types'             => [
        'family_member'         => 'Membro da família',
        'organisation_member'   => 'Membro da organização',
    ],
    'update'            => [
        'success'   => 'Relação :target atualizada para :entity.',
        'title'     => 'Atualizar relações para :name',
    ],
];

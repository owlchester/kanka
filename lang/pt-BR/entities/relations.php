<?php

return [
    'actions'           => [
        'mode-map'      => 'Ferramenta de exploração das conexões',
        'mode-table'    => 'Tabela de conexões e elementos relacionados',
    ],
    'bulk'              => [
        'delete'    => '{1} :count conexão removida. |[2,*] :count conexões removidas.',
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
            'editing'           => '{1} :count conexão foi atualizada. |[2,*] :count conexões foram atualizadas.',
            'editing_partial'   => '{1} :count/:total conexão foi atualizada. |[2,*] :count/:total conexões foram atualizadas.',
        ],
    ],
    'call-to-action'    => 'Explore visualmente as conexões dessa entidade e como ela está conectada ao restante da campanha.',
    'connections'       => [
        'map_point'         => 'Ponto do mapa',
        'mention'           => 'Menção',
        'quest_element'     => 'Elemento de missão',
        'timeline_element'  => 'Elemento de linha do tempo',
    ],
    'create'            => [
        'helper'        => 'Crie uma conexão entre :name e uma ou várias entidades.',
        'new_title'     => 'Nova conexão',
        'success_bulk'  => '{1} Adicionada :count conexão a :entity.|[2,*] Adicionadas :count conexões a :entity.',
    ],
    'delete_mirrored'   => [
        'helper'    => 'Essa conexão é espelhada na entidade alvo. Selecione essa opção para também remover  a conexão espelhada.',
        'option'    => 'Remover conexão espelhada',
    ],
    'destroy'           => [
        'mirrored'  => 'Isso também removerá a conexão espelhada e é permanente.',
        'success'   => 'Conexão de :target removida para :entity.',
    ],
    'fields'            => [
        'attitude'          => 'Atitude',
        'connection'        => 'Conexão',
        'is_pinned'         => 'Fixado',
        'owner'             => 'Fonte',
        'relation'          => 'Descrição',
        'target'            => 'Entidade alvo',
        'target_relation'   => 'Descrição do alvo',
        'targets'           => 'Entidades alvo',
        'two_way'           => 'Conexão espelhada',
        'unmirror'          => 'Desespelhe esta conexão.',
    ],
    'filters'           => [
        'connection'    => 'Relação da conexão',
        'name'          => 'Conexão alvo',
    ],
    'helper'            => 'Estabeleça conexões entre entidades com atitudes e visibilidade. Conexões também podem ser fixadas no menu da entidade.',
    'helpers'           => [
        'description'   => 'Detalhe a natureza da conexão entre as duas entidades.',
        'no_relations'  => 'Essa entidade atualmente não tem quaisquer outras conexões com outras entidades da campanha.',
    ],
    'hints'             => [
        'attitude'          => 'Este campo opcional pode ser usado para definir a ordem padrão em que as conexões aparecem em ordem decrescente.',
        'mirrored'          => [
            'text'  => 'Esta conexão é espelhada com :link.',
            'title' => 'Espelhada',
        ],
        'target_relation'   => 'A descrição da conexão no alvo. Deixe em branco para usar o texto desta conexão.',
        'two_way'           => 'Crie uma conexão no alvo selecionado e espelhe-os. Atualizar uma relação espelhada não atualiza a conexão original.',
    ],
    'index'             => [
        'title' => 'Conexões',
    ],
    'options'           => [
        'mentions'          => 'Padrão + relacionados + menções',
        'only_relations'    => 'Apenas conexões diretas',
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
        'title' => 'Conexões de :name',
    ],
    'types'             => [
        'family_member'         => 'Membro da família',
        'organisation_member'   => 'Membro da Organização',
    ],
    'update'            => [
        'success'   => 'Conexão :target atualizada para :entity.',
        'title'     => 'Atualizar conexões para :name',
    ],
];

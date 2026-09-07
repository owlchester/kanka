<?php

return [
    'actions'           => [
        'mode-map'      => 'Mapa de relações',
        'mode-table'    => 'Tabela de relações e elementos relacionados',
    ],
    'bulk'              => [
        'delete'    => '{1} :count relação removida. |[2,*] :count relações removidas.',
        'fields'    => [
            'delete_mirrored'   => 'Excluir espelhado',
            'unmirror'          => 'Desvincular espelhado',
            'update_mirrored'   => 'Atualizar espelhado',
        ],
        'helpers'   => [
            'delete_mirrored'   => 'Exclua também as relações espelhadas.',
            'unmirror'          => 'Desvincula relações espelhadas.',
            'update_mirrored'   => 'Atualiza relações espelhadas.',
        ],
        'success'   => [
            'editing'           => '{1} :count relação foi atualizada. |[2,*] :count relações foram atualizadas.',
            'editing_partial'   => '{1} :count/:total relação foi atualizada. |[2,*] :count/:total relações foram atualizadas.',
        ],
    ],
    'call-to-action'    => 'Explore visualmente como esta entidade se conecta a outras na campanha. Visualize relacionamentos, menções e o histórico compartilhado em um mapa dinâmico e interativo.',
    'connections'       => [
        'map_point'         => 'Ponto do mapa',
        'mention'           => 'Menção',
        'quest_element'     => 'Elemento de missão',
        'timeline_element'  => 'Elemento de linha do tempo',
    ],
    'create'            => [
        'helper'        => 'Crie uma relação entre :name e uma ou várias entidades.',
        'new_title'     => 'Nova relação',
        'success_bulk'  => '{1} Adicionada :count relação a :entity.|[2,*] Adicionadas :count relações a :entity.',
    ],
    'delete_mirrored'   => [
        'helper'    => 'Essa relação é espelhada na entidade alvo. Selecione essa opção para também remover a relação espelhada.',
        'option'    => 'Remover relação espelhada',
    ],
    'destroy'           => [
        'mirrored'  => 'Isso também removerá a relação espelhada e é permanente.',
        'success'   => 'Relação de :target removida para :entity.',
    ],
    'empty'             => 'Nada para ver aqui',
    'fields'            => [
        'attitude'          => 'Atitude',
        'is_pinned'         => 'Fixado',
        'link'              => 'Vínculo recíproco',
        'mirror_relation'   => 'Função recíproca',
        'owner'             => 'Origem',
        'role'              => 'Função',
        'target'            => 'Destino',
        'targets'           => 'Conexão com...',
        'two_way'           => 'Recíproco',
        'unmirror'          => 'Desespelhe esta relação.',
    ],
    'filters'           => [
        'connection'    => 'Relação da relação',
        'name'          => 'Relação destino',
    ],
    'helper'            => 'Estabeleça relações entre entidades com atitudes e visibilidade. Relações também podem ser fixadas no menu da entidade.',
    'helpers'           => [
        'description'       => 'Detalhe a natureza da relação entre as duas entidades.',
        'link'              => 'Crie uma relação de correspondência nos alvos.',
        'mirror_relation'   => 'Como o destino vê esta entidade (deixe em branco para copiar a de cima).',
        'no_relations'      => 'Essa entidade atualmente não tem quaisquer outras relações com outras entidades da campanha.',
    ],
    'hints'             => [
        'attitude'  => 'Este campo opcional pode ser usado para definir a ordem padrão em que as relações aparecem em ordem decrescente.',
        'two_way'   => 'Crie uma relação no destino selecionado e espelhe-os. Atualizar uma relação espelhada não atualiza a relação original.',
    ],
    'index'             => [
        'title' => 'Relações',
    ],
    'linked'            => [
        'break'             => 'Quebrar vínculo',
        'helper'            => 'Esta relação está sincronizada com :link',
        'label'             => 'Relação vinculada',
        'unmirror-helper'   => 'Converter isso em uma relação independente não excluirá nada.',
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
        'attitude'  => '-100 a 100, 100 sendo muito positiva',
        'role'      => 'Rival, Melhor Amigo, Irmão',
    ],
    'show'              => [
        'title' => 'Relações de :name',
    ],
    'types'             => [
        'family_member'         => 'Membro da família',
        'organisation_member'   => 'Membro da Organização',
    ],
    'update'            => [
        'success'   => 'Relação :target atualizada para :entity.',
        'title'     => 'Atualizar relações entre :source e :target',
    ],
];

<?php

return [
    'actions'       => [
        'add'   => 'Adicionar uma nova camada',
    ],
    'base'          => 'Camada Base',
    'bulks'         => [
        'delete'    => '{1} Removida :count camada.|[2,*] Removidas :count camadas.',
        'patch'     => '{1} Atualizada :count camada.|[2,*] Atualizadas :count camadas.',
    ],
    'create'        => [
        'success'   => 'Camada :name criada.',
        'title'     => 'Nova Camada',
    ],
    'delete'        => [
        'success'   => 'Camada :name removida.',
    ],
    'edit'          => [
        'success'   => 'Camada :name atualizada.',
        'title'     => 'Editar Camada :name',
    ],
    'fields'        => [
        'position'  => 'Posição',
        'type'      => 'Tipo de camada',
    ],
    'helper'        => [
        'amount_v2' => 'Carregue camadas em um mapa para alternar a imagem de plano de fundo exibida abaixo dos marcadores ou como sobreposições acima do mapa, mas abaixo dos marcadores.',
        'is_real'   => 'Camadas não estão disponíveis ao usar OpenStreetMaps.',
    ],
    'index'         => [
        'title' => 'Camadas de :name',
    ],
    'pitch'         => [
        'max'       => [
            'helper'    => 'Não é possível adicionar mais camadas a menos que você remova uma existente.',
            'limit'     => 'Este mapa atingiu seu limite de camadas',
        ],
        'upgrade'   => [
            'limit'     => 'Você atingiu o limite de :limit camadas para este mapa',
            'upgrade'   => 'Atualize para uma campanha premium para adicionar até :limit camadas e desbloquear ainda mais flexibilidade criativa.',
        ],
    ],
    'placeholders'  => [
        'name'          => 'Subterrãneo, Nível 2, Navio Naufragado',
        'position'      => 'Primeiro',
        'position_list' => 'Depois de :name',
    ],
    'reorder'       => [
        'save'      => 'Salvar nova ordem',
        'success'   => '{1} Reordenada :count camada.|[2,*] Reordenadas :count camadas.',
        'title'     => 'Reordenar camadas',
    ],
    'short_types'   => [
        'overlay'       => 'Sobreposição',
        'overlay_shown' => 'Sobreposição (mostrar automaticamente)',
        'standard'      => 'Padrão',
    ],
    'types'         => [
        'overlay'       => 'Sobreposição (exibido acima da camada ativa)',
        'overlay_shown' => 'Sobreposição exibida por padrão',
        'standard'      => 'Camada padrão (alternar entre camadas)',
    ],
];

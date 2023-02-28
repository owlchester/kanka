<?php

return [
    'actions'       => [
        'add'   => 'Adicionar uma nova camada',
    ],
    'base'          => 'Camada base',
    'bulks'         => [
        'delete'    => '{1} Removida :count camada.|[2,*] Removidas :count camadas.',
        'patch'     => '{1} Atualizada :count camada.|[2,*] Atualizadas :count camadas.',
    ],
    'create'        => [
        'success'   => 'Camada :name criada',
        'title'     => 'Nova camada',
    ],
    'delete'        => [
        'success'   => 'Camada :name deletada',
    ],
    'edit'          => [
        'success'   => 'Camada :name atualizada',
        'title'     => 'Editar camada :name',
    ],
    'fields'        => [
        'position'  => 'Posição',
        'type'      => 'Tipo de camada',
    ],
    'helper'        => [
        'amount_v2' => 'Carregue camadas em um mapa para alternar a imagem de fundo exibida abaixo dos marcadores.',
        'is_real'   => 'Camadas não estão disponíveis ao usar OpenStreetMaps.',
    ],
    'index'         => [
        'title' => 'Camadas de :name',
    ],
    'pitch'         => [
        'error' => 'Número máximo de camadas alcançado.',
        'until' => 'Carregue até :max camadas para cada mapa.',
    ],
    'placeholders'  => [
        'name'          => 'Subterrãneo, segundo nível, navio naufragado',
        'position'      => 'Campo opcional para definir a ordem em que as camadas aparecem.',
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
        'overlay'       => 'Sobreposição (mostrado acima da camada ativa)',
        'overlay_shown' => 'Sobreposição mostrada de modo padrão.',
        'standard'      => 'Camada padrão (alternar entre camadas)',
    ],
];

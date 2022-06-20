<?php

return [
    'actions'       => [
        'add'   => 'Adicionar uma nova camada',
    ],
    'base'          => 'Camada base',
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
        'is_real'   => 'Camadas não estão disponíveis ao usar OpenStreetMaps.',
    ],
    'placeholders'  => [
        'name'      => 'Subterrãneo, segundo nível, navio naufragado',
        'position'  => 'Campo opcional para definir a ordem em que as camadas aparecem.',
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

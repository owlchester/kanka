<?php

return [
    'actions'       => [
        'add'   => 'Afegeix una capa nova',
    ],
    'base'          => 'Capa base',
    'create'        => [
        'success'   => 'S\'ha creat la capa «:name».',
        'title'     => 'Nova capa',
    ],
    'delete'        => [
        'success'   => 'S\'ha eliminat la capa «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat la capa «:name».',
        'title'     => 'Edita la capa :name',
    ],
    'fields'        => [
        'position'  => 'Posició',
        'type'      => 'Tipus de capa',
    ],
    'helper'        => [
        'is_real'   => 'Les capes no estan habilitades amb l\'OpenStreetMaps.',
    ],
    'placeholders'  => [
        'name'      => 'Subterrani, nivell 2, naufragi...',
        'position'  => 'Camp opcional per a definir en quin ordre s\'apilen les capes.',
    ],
    'short_types'   => [
        'overlay'       => 'Superposició',
        'overlay_shown' => 'Superposició (mostra automàticament)',
        'standard'      => 'Estàndard',
    ],
    'types'         => [
        'overlay'       => 'Superposició (es mostra sobre la capa activa)',
        'overlay_shown' => 'Superposició mostrada per defecte',
        'standard'      => 'Capa estàndard (canvia entre capes)',
    ],
];

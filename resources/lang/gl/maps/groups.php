<?php

return [
    'actions'       => [
        'add'   => 'Engadir un novo grupo',
    ],
    'create'        => [
        'success'   => 'Grupo ":name" creado.',
        'title'     => 'Novo grupo',
    ],
    'delete'        => [
        'success'   => 'Grupo ":name" eliminado.',
    ],
    'edit'          => [
        'success'   => 'Grupo ":name" actualizado.',
        'title'     => 'Editar grupo ":name"',
    ],
    'fields'        => [
        'is_shown'  => 'Mostrar marcadores do grupo',
        'position'  => 'Posición',
    ],
    'helper'        => [
        'amount'            => 'Os marcadores asociados a un grupo poden ser mostrados ou ocultados todos á vez (por exemplo, para mostrar ou ocultar todas as tendas dunha cidade). Un mapa pode ter ata :amount grupos.',
        'boosted_campaign'  => 'As :boosted poden ter ata :amount grupos.',
    ],
    'hints'         => [
        'is_shown'  => 'Se está seleccionado, os marcadores do grupo serán mostrados no mapa por defecto.',
    ],
    'placeholders'  => [
        'name'      => 'Tendas, tesouros, PNXs...',
        'position'  => 'Campo opcional para establecer a orde na que aparecen os grupos.',
    ],
];

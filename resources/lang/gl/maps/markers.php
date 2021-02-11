<?php

return [
    'actions'       => [
        'remove'    => 'Eliminar marcador',
        'update'    => 'Editar marcador',
    ],
    'create'        => [
        'success'   => 'Marcador ":name" creado.',
        'title'     => 'Novo marcador',
    ],
    'delete'        => [
        'success'   => 'Marcador ":name" eliminado.',
    ],
    'edit'          => [
        'success'   => 'Marcador ":name" actualizado.',
        'title'     => 'Editar marcador ":name"',
    ],
    'fields'        => [
        'custom_icon'   => 'Icona personalizada',
        'custom_shape'  => 'Forma personalizada',
        'font_colour'   => 'Cor da icona',
        'group'         => 'Grupo de marcadores',
        'is_draggable'  => 'Arrastrábel',
        'latitude'      => 'Latitude',
        'longitude'     => 'Lonxitude',
        'opacity'       => 'Opacidade',
        'pin_size'      => 'Tamaño do marcador',
    ],
    'helpers'       => [
        'base'          => 'Engade marcadores ao mapa facendo clic en calquer punto.',
        'custom_icon'   => 'Copia o HTML dunha icona de :fontawesome ou de :rpgawesome, ou unha icona SVG personalizada.',
        'draggable'     => 'Actívao para poder mover un marcador no modo de exploración.',
    ],
    'icons'         => [
        'custom'        => 'Personalizado',
        'entity'        => 'Entidade',
        'exclamation'   => 'Exclamación',
        'marker'        => 'Marcador',
        'question'      => 'Interrogación',
    ],
    'placeholders'  => [
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Necesario se non hai ningunha entidade seleccionada',
    ],
    'shapes'        => [
        '0' => 'Círculo',
        '1' => 'Cadrado',
        '2' => 'Triángulo',
        '3' => 'Personalizada',
    ],
    'sizes'         => [
        '0' => 'Minúsculo',
        '1' => 'Estándar',
        '2' => 'Pequeno',
        '3' => 'Grande',
        '4' => 'Enorme',
    ],
    'tabs'          => [
        'circle'    => 'Círculo',
        'label'     => 'Rótulo',
        'marker'    => 'Marcador',
        'polygon'   => 'Polígono',
    ],
];

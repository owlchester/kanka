<?php

return [
    'actions'   => [
        'customise' => 'Personalizar',
    ],
    'fields'    => [
        'icon'      => 'Icono del módulo',
        'plural'    => 'Nombre del módulo en plural',
        'singular'  => 'Nombre del módulo en singular',
    ],
    'helpers'   => [
        'info'  => 'Una campaña se divide en varios módulos que interactúan entre sí. Habilita o deshabilita los que no necesites. Deshabilitar un módulo no elimina ninguno de sus datos, solo los oculta.',
    ],
    'pitch'     => 'Cambia el nombre y el icono asociado a este módulo para toda la campaña.',
    'rename'    => [
        'helper'    => 'Cambia el nombre y el icono del módulo a lo largo de la campaña. Déjalo en blanco para usar el predeterminado de Kanka.',
        'success'   => 'Módulo personalizado.',
        'title'     => 'Personalizar el módulo :module',
    ],
    'reset'     => [
        'success'   => 'Los módulos de la campaña se han restablecido.',
        'title'     => 'Restablecer los nombres e iconos personalizados de los módulos',
        'warning'   => '¿Estás seguro de que quieres restablecer los nombres e iconos originales de los módulos de campaña?',
    ],
    'states'    => [
        'disable'   => 'Desactivar',
        'enable'    => 'Activar',
    ],
];

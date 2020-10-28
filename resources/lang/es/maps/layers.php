<?php

return [
    'actions'       => [
        'add'   => 'Añadir nueva capa',
    ],
    'base'          => 'Capa base',
    'create'        => [
        'success'   => 'Capa :name creada.',
        'title'     => 'Nueva capa',
    ],
    'delete'        => [
        'success'   => 'Capa :name eliminada.',
    ],
    'edit'          => [
        'success'   => 'Capa :name actualizada.',
        'title'     => 'Editar capa :name',
    ],
    'fields'        => [
        'position'  => 'Posición',
        'type'      => 'Tipo de capa',
    ],
    'helper'        => [
        'amount'            => 'Puedes añadir hasta :amount capas en un mapa para cambiar la imagen de fondo que se muestra bajo los marcadores.',
        'boosted_campaign'  => ':boosted pueden tener hasta :amount capas.',
    ],
    'placeholders'  => [
        'name'      => 'Subterráneo, nivel 2, naufragio...',
        'position'  => 'Campo opcional para definir en qué orden se apilan las capas.',
    ],
    'short_types'   => [
        'overlay'       => 'Superposición',
        'overlay_shown' => 'Superposición (mostrar automáticamente)',
        'standard'      => 'Estándar',
    ],
    'types'         => [
        'overlay'       => 'Superposición (se muestra sobre la capa activa)',
        'overlay_shown' => 'Superposición mostrada por defecto',
        'standard'      => 'Capa estándar (cambia entre capas)',
    ],
];

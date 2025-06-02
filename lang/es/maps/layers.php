<?php

return [
    'actions'       => [
        'add'   => 'Añadir nueva capa',
    ],
    'base'          => 'Capa base',
    'bulks'         => [
        'delete'    => '{1} Se ha eliminado :count capa.|[2,*] Se han eliminado :count capas.',
        'patch'     => '{1} Se ha actualizado :count capa.|[2,*] Se han actualizado :count capas.',
    ],
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
        'amount_v2' => 'Cargue capas en un mapa para cambiar la imagen de fondo que se muestra debajo de los marcadores, o como superposiciones sobre el mapa pero debajo de los marcadores.',
        'is_real'   => 'Las capas no están disponibles con OpenStretMaps.',
    ],
    'index'         => [
        'title' => 'Capas de :name',
    ],
    'pitch'         => [],
    'placeholders'  => [
        'name'          => 'Subterráneo, nivel 2, naufragio...',
        'position'      => 'Campo opcional para definir en qué orden se apilan las capas.',
        'position_list' => 'Después de :name',
    ],
    'reorder'       => [
        'save'      => 'Guardar nuevo orden',
        'success'   => '{1} Se ha reordenado :count capa.|[2,*] Se han reordenado :count capas.',
        'title'     => 'Reordenar capas',
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

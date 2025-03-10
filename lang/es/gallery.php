<?php

return [
    'actions'   => [
        'gallery'   => 'De la galería',
        'url'       => 'Subir una imagen desde una URL',
    ],
    'browse'    => [
        'layouts'       => [
            'large' => 'Previsualizaciones grandes',
            'small' => 'Previsualizaciones pequeñas',
        ],
        'search'        => [
            'placeholder'   => 'Buscar una imagen en la galería',
        ],
        'title'         => 'Galería',
        'unauthorized'  => 'Ninguno de tus roles tiene el permiso "navegar por la galería".',
    ],
    'cta'       => [
        'action'    => 'Desbloquear más espacio de almacenamiento',
        'helper'    => 'Desbloquea hasta :size GB de espacio de almacenamiento con una campaña :premium.',
        'title'     => 'Almacenamiento lleno',
    ],
    'delete'    => [
        'success'   => '[0] Se han eliminado 0 elementos|[1] Se ha eliminado un elemento|{2,*} Se han eliminado :count elementos',
    ],
    'download'  => [
        'errors'    => [
            'copy_failed'           => 'Nuestros servidores no han podido descargar la imagen.',
            'gallery_full_free'     => 'El espacio de almacenamiento de la galería está lleno. Activa las funciones premium para obtener más espacio de almacenamiento.',
            'gallery_full_premium'  => 'El espacio de almacenamiento de la galería está lleno. Elimina los archivos que no utilices.',
            'invalid_format'        => 'El archivo no tiene un formato válido.',
            'too_big'               => 'El archivo es demasiado grande (:size MB vs :max MB)',
            'unauthorized'          => 'Ninguno de tus roles tiene el permiso "subir a galería".',
        ],
    ],
    'file'      => [
        'saved' => 'Guardado',
    ],
    'filters'   => [
        'only_unused'   => 'Mostrar sólo los archivos no utilizados',
    ],
    'move'      => [
        'success'   => '[0] Se han movido 0 elementos|[1] Se ha movido un elemento|{2,*} Se han movido :count elementos',
    ],
    'update'    => [
        'home'      => 'Carpeta de inicio',
        'success'   => '[0] Se han atualizado 0 elementos|[1] Se ha actualizado un elemento|{2,*} Se han actualizado :count elementos',
    ],
];

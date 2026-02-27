<?php

return [
    'actions'   => [
        'show-old'  => 'Cambios',
    ],
    'cta'       => 'Mostrar un registro de todos los cambios recientes en la campaña.',
    'empty'     => 'Sin valor',
    'fields'    => [
        'action'    => 'Acción',
        'category'  => 'Categoría',
        'details'   => 'Detalles',
        'when'      => 'Cuándo',
        'who'       => 'Quién',
    ],
    'filters'   => [
        'all-actions'   => 'Todas las acciones',
        'all-users'     => 'Todos los miembros',
        'no-results'    => 'No hay resultados que mostrar. Prueba con otros filtros o vuelve después de hacer cambios en las entidades de la campaña.',
    ],
    'helpers'   => [
        'base'      => 'Esta interfaz contiene los cambios recientes en las entidades de la campaña durante un máximo de :amount meses, mostrando primero los cambios más recientes.',
        'changes'   => 'Los siguientes campos tenían estos valores anteriormente.',
    ],
    'log'       => [
        'create'        => ':user ha creado :entity',
        'create_post'   => ':user creó el post ":post" en :entidad',
        'delete'        => ':user eliminó :entity',
        'delete_post'   => ':user ha eliminado un post en :entity',
        'reorder_post'  => ':user reordenó los posts de :entity',
        'restore'       => ':user restauró :entity',
        'update'        => ':user actualizó :entity',
        'update_post'   => ':user actualizó el post ":post" en :entity',
        'update_tree'   => ':user actualizó el árbol genealógico de :entity',
    ],
    'title'     => 'Historial',
    'unknown'   => [
        'entity'    => 'una entidad desconocida',
    ],
];

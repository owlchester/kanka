<?php

return [
    'actions'       => [
        'add_element'   => 'Añadir elemento a la era :era',
        'back'          => 'Volver a :name',
        'edit'          => 'Editar línea de tiempo',
        'reorder'       => 'Reordenar',
        'save_order'    => 'Guardar orden nuevo',
    ],
    'create'        => [
        'title' => 'Nueva línea de tiempo',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'copy_elements' => 'Copiar elementos',
        'copy_eras'     => 'Copiar eras',
        'eras'          => 'Eras',
        'name'          => 'Nombre',
        'reverse_order' => 'Era en orden inverso',
        'timeline'      => 'Línea de tiempo superior',
        'timelines'     => 'Líneas de tiempo',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested_parent'     => 'Mostrando las líneas de tiempo de :parent.',
        'nested_without'    => 'Mostrando todas las líneas de tiempo sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
        'reorder'           => 'Arrastra los elementos de la era para reordenarlos.',
        'reorder_tooltip'   => 'Haz clic para habilitar la reordenación manual de los elementos mediante arrastrar y soltar.',
        'reverse_order'     => 'Habilitar para mostrar las eras en orden cronológico inverso (la era más antigua primero)',
    ],
    'index'         => [
        'title' => 'Líneas de tiempo',
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la línea de tiempo',
        'type'  => 'Primaria, Crónica del mundo, Legado del reino...',
    ],
    'show'          => [
        'tabs'  => [
            'timelines' => 'Líneas de tiempo',
        ],
    ],
    'timelines'     => [
        'title' => 'Líneas de tiempo de :name',
    ],
];

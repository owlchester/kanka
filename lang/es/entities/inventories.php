<?php

return [
    'actions'           => [
        'copy_from_entity'  => 'Copiar desde otra entidad',
        'copy_inventory'    => 'Copiar inventario',
        'generate'          => 'Generar',
        'multiple'          => 'Añadir elementos',
    ],
    'copy'              => [
        'helper'    => 'Copiar todo el inventario de una entidad a :name.',
    ],
    'create'            => [
        'helper'        => 'Agrega un objeto al inventario de :name. Opcionalmente, puede estar vinculado a un objeto existente de la campaña.',
        'success'       => 'Objeto :item añadido a :name',
        'success_bulk'  => '{0} No se ha añadido ningún objeto a :entity.|{1} Se ha añadido :count objeto a :entity.|[2,*] Se han añadido :count objetos a :entity.',
        'title'         => 'Añade un objeto a :name',
    ],
    'default_position'  => 'Sin organizar',
    'destroy'           => [
        'success'           => 'Objeto :item eliminado de :entity.',
        'success_position'  => 'Elementos en :position eliminados de :entity.',
    ],
    'fields'            => [
        'amount'                => 'Cantidad',
        'copy_entity_entry_v2'  => 'Utilizar entrada del objeto',
        'description'           => 'Observaciones',
        'is_equipped'           => 'Equipado',
        'item_amount'           => 'Número de objetos',
        'match_all'             => 'Coincidir todas las etiquetas',
        'name'                  => 'Nombre',
        'position'              => 'Localización',
        'qty'                   => 'Cantidad',
        'replace'               => 'Reemplazar inventario',
    ],
    'generate'          => [
        'helper'    => 'Generar un inventario para :name basado en los objetos existentes en la campaña.',
        'title'     => 'Generar inventario',
    ],
    'helpers'           => [
        'amount'                => 'Número de objetos',
        'copy_entity_entry_v2'  => 'Mostrar la entrada del objeto en lugar de la descripción personalizada.',
        'description'           => 'Añadir una descripción personalizada al objeto',
        'is_equipped'           => 'Marca estos objetos como equipados.',
        'name'                  => 'Da nombre al objeto. Se requiere un nombre si no se selecciona ningún objeto',
        'replace'               => 'Reemplaza el inventario actual por el generado.',
    ],
    'placeholders'      => [
        'amount'        => 'Cualquier cantidad',
        'description'   => 'Usado, dañado, roto',
        'name'          => 'Requerido si no se selecciona ningún objeto',
        'position'      => 'Equipado, Mochila, Almacenamiento, Banco...',
    ],
    'show'              => [
        'helper'    => 'Las entidades pueden tener objetos asociados a ellas, creando así un inventario.',
        'title'     => 'Inventario de :name',
        'unsorted'  => 'Sin clasificar',
    ],
    'togglers'          => [
        'hide'  => [
            'price'     => 'Ocultar precio',
            'quantity'  => 'Ocultar cantidad',
            'size'      => 'Ocultar tamaño',
            'weight'    => 'Ocultar peso',
        ],
        'show'  => [
            'price'     => 'Mostrar precio',
            'quantity'  => 'Mostrar cantidad',
            'size'      => 'Mostrar tamaño',
            'weight'    => 'Mostrar peso',
        ],
    ],
    'tooltips'          => [
        'equipped'  => 'Este objeto está equipado',
    ],
    'tutorials'         => [
        'all'   => 'Lleva un registro de lo que :name posee, almacena u ofrece añadiendo objetos a este inventario.',
    ],
    'update'            => [
        'success'   => 'Objeto :item actualizado en :entity.',
        'title'     => 'Actualizar un objeto de :name',
    ],
];

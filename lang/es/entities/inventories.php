<?php

return [
    'actions'           => [
        'add'               => 'Añadir objeto',
        'copy_from'         => 'Copiar de',
        'copy_inventory'    => 'Copiar inventario',
    ],
    'copy'              => [
        'title' => 'Copiar inventario a :name',
    ],
    'create'            => [
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
        'name'                  => 'Nombre',
        'position'              => 'Localización',
        'qty'                   => 'Cantidad',
    ],
    'helpers'           => [
        'amount'                => 'Número de objetos',
        'copy_entity_entry_v2'  => 'Mostrar la entrada del objeto en lugar de la descripción personalizada.',
        'description'           => 'Añadir una descripción personalizada al objeto',
        'is_equipped'           => 'Marca estos objetos como equipados.',
        'name'                  => 'Da nombre al objeto. Se requiere un nombre si no se selecciona ningún objeto',
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
    'tooltips'          => [
        'equipped'  => 'Este objeto está equipado',
    ],
    'tutorials'         => [
        'character' => 'Mantente al tanto de lo que :name posee o tiene a la venta añadiendo artículos a su inventario.',
        'location'  => 'Mantente al tanto de lo que :name tiene a la venta o para saquear añadiendo objetos a su inventario.',
        'other'     => 'Lleva la cuenta de las posesiones de :name añadiendo objetos a su inventario.',
    ],
    'update'            => [
        'success'   => 'Objeto :item actualizado en :entity.',
        'title'     => 'Actualizar un objeto de :name',
    ],
];

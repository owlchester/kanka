<?php

return [
    'create'        => [
        'success'   => 'Vinculo añadido para :name.',
        'title'     => 'Crear vinculo',
    ],
    'destroy'       => [
        'success'   => 'Vinculo eliminado para :name.',
    ],
    'edit'          => [
        'success'   => 'Vinculo actualizado para :name.',
        'title'     => 'Actualizar vinculos',
    ],
    'fields'        => [
        'relation'  => 'Vinculos',
        'target'    => 'Selección',
        'two_way'   => 'Reflejar vinculo creado',
    ],
    'hints'         => [
        'two_way'   => 'Si eliges crear un reflejo, el mismo vinculo sera reflejado en el objeto seleccionado. Sin embargo, si editas uno, el otro no se verá afectado.',
    ],
    'placeholders'  => [
        'relation'  => 'Naturaleza del vinculo',
        'target'    => 'Elige una entidad',
    ],
];

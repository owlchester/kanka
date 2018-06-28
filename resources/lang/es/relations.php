<?php

return [
    'create'        => [
        'description'   => 'Crear nuevo vínculo',
        'success'       => 'Vínculo añadido para :name.',
        'title'         => 'Crear Vínculo',
    ],
    'destroy'       => [
        'success'   => 'Vínculo eliminado para :name.',
    ],
    'edit'          => [
        'success'   => 'Vínculo actualizado para :name.',
        'title'     => 'Actualizar vínculos',
    ],
    'fields'        => [
        'relation'  => 'Vínculo',
        'target'    => 'Selección',
        'two_way'   => 'Reflejar vínculo creado',
    ],
    'hints'         => [
        'two_way'   => 'Si eliges crear un reflejo, el mismo vínculo será reflejado en el objeto seleccionado. Sin embargo, si editas uno, el otro no se verá afectado.',
    ],
    'placeholders'  => [
        'relation'  => 'Naturaleza del vínculo',
        'target'    => 'Elige una entidad',
    ],
];

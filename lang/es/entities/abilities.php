<?php

return [
    'actions'   => [
        'add'   => 'Añadir habilidad',
        'reset' => 'Restablecer usos de habilidad',
        'sync'  => 'Añadir desde razas',
    ],
    'charges'   => [
        'left'  => ':amount restante',
    ],
    'create'    => [
        'helper'            => 'Vincula una o varias habilidades a :name.',
        'success'           => 'Habilidad :ability añadida a :entity.',
        'success_multiple'  => 'Habilidades :abilities añadidas a :entity.',
        'title'             => 'Añadir habilidad a :name',
    ],
    'fields'    => [
        'note'      => 'Nota',
        'position'  => 'Posición',
    ],
    'groups'    => [
        'unorganised'   => 'Sin organizar',
    ],
    'helpers'   => [
        'note'      => 'Puedes referenciar entidades mediante las menciones avanzadas (por ejemplo, :code) y atributos de la entidad (por ejemplo, :attr) en este campo.',
        'recharge'  => 'Restablece todos las cargas de las habilidades que se han utilizado.',
        'sync'      => 'Importa habilidades que estén definidas en las razas del personaje.',
    ],
    'import'    => [
        'errors'            => [
            'no_race'       => 'El personaje no tiene raza.',
            'not_character' => 'La entidad no es un personaje.',
        ],
        'helper'            => 'Adjunta habilidades de las siguientes razas a las que pertenece :name:',
        'no_abilities'      => 'Actualmente no hay habilidades para importar de las razas a las que pertenece :name.',
        'race_abilities'    => '{1} :name (:count habilidad) |[2,*] :name (:count habilidades)',
        'success'           => '{1} Se han importado :count habilidades.|[2,*] Se han importado :count habilidades.',
    ],
    'recharge'  => [
        'success'   => 'Se han restablecido todos las cargas.',
    ],
    'reorder'   => [
        'parentless'    => 'Sin padre',
        'success'       => 'Habilidades reordenadas con éxito',
    ],
    'show'      => [
        'helper'    => 'Adjunta habilidades a esta entidad. Puedes modificar su visibilidad o eliminarlas más adelante. Las habilidades pertenecientes al mismo grupo se agrupan por tipos.',
        'reorder'   => 'Reordenar',
        'title'     => 'Habilidades de :name',
    ],
    'types'     => [
        'unorganised'   => 'Las habilidades se agrupan por su campo de origen, y en su defecto se encuentran aquí.',
    ],
    'update'    => [
        'success'   => 'Habilidad de la entidad :ability actualizada.',
        'title'     => 'Habilidad de :name',
    ],
];

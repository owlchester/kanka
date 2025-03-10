<?php

return [
    'fields'    => [
        'type'  => 'Tipo de evento',
    ],
    'helpers'   => [
        'characters'    => 'Al seleccionar fecha de nacimiento o de fallecimiento, se calculará automáticamente la edad de este personaje. :more',
        'founding'      => 'Al establecer el tipo como :type se calculará automáticamente la antigüedad de la entidad desde su fundación.',
        'reminders'     => 'Los recordatorios vinculados a :name se mostrarán aquí.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Añadir recordatorio',
        ],
        'title'     => 'Recordatorios de :name',
    ],
    'types'     => [
        'birth'     => 'Nacimiento',
        'birthday'  => 'Cumpleaños',
        'death'     => 'Muerte',
        'founded'   => 'Fundación',
        'primary'   => 'Primario',
    ],
    'years-ago' => '{1} :count año atrás|[2,*] :count años atrás',
];

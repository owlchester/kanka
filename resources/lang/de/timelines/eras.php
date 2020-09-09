<?php

return [
    'actions'       => [
        'add'   => 'neue Epoche hinzufügen',
    ],
    'create'        => [
        'success'   => 'Epoche :name erstellt',
        'title'     => 'neue Epoche',
    ],
    'delete'        => [
        'success'   => 'Epoche :name gelöscht',
    ],
    'edit'          => [
        'success'   => 'Epoche :name aktualisiert',
        'title'     => 'Epoche :name editieren',
    ],
    'fields'        => [
        'abbreviation'  => 'Abkürzung',
        'end_year'      => 'Endjahr',
        'start_year'    => 'Startjahr',
    ],
    'helpers'       => [
        'eras'      => 'Der Zeitstahl muss erstellt werden, bevor Epochen hinzugefügt werden können.',
        'primary'   => 'Trennen Sie Ihre Zeitstrahlen in Epochen. Ein Zeitstrahl benötigt mindestens eine Epoche, um ordnungsgemäß zu funktionieren.',
    ],
    'placeholders'  => [
        'abbreviation'  => 'AD, BC, BCE',
        'end_year'      => 'Jahr, in dem die Epoche endet. Lassen Sie das Feld leer, wenn dies die aktuelle Epoche ist.',
        'name'          => 'Moderne, Bronzzeit, Galaktische Kriege',
        'start_year'    => 'Jahr, in dem die Epoche beginnt. Lassen Sie das Feld leer, wenn dies die erste Epoche ist.',
    ],
    'reorder'       => [
        'success'   => 'Elemente der :era Epoche  neu geordnet.',
    ],
];

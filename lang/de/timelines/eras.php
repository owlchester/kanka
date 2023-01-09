<?php

return [
    'actions'       => [
        'add'   => 'neue Epoche hinzufügen',
    ],
    'bulks'         => [
        'delete'    => '{0} :count eras entfernt.|{1} :count eras entfernt.|[2,*] :count eras entfernt.',
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
        'is_collapsed'  => 'eingeklappt',
        'start_year'    => 'Startjahr',
    ],
    'helpers'       => [
        'eras'          => 'Der Zeitstahl muss erstellt werden, bevor Epochen hinzugefügt werden können.',
        'is_collapsed'  => 'Era ist standardmäßig eingeklappt (minimiert).',
        'primary'       => 'Trennen Sie Ihre Zeitstrahlen in Epochen. Ein Zeitstrahl benötigt mindestens eine Epoche, um ordnungsgemäß zu funktionieren.',
    ],
    'index'         => [
        'title' => 'Epochen von :name',
    ],
    'placeholders'  => [
        'abbreviation'  => 'AD, BC, BCE',
        'end_year'      => 'Jahr, in dem die Epoche endet. Lassen Sie das Feld leer, wenn dies die aktuelle Epoche ist.',
        'name'          => 'Moderne, Bronzzeit, Galaktische Kriege',
        'start_year'    => 'Jahr, in dem die Epoche beginnt. Lassen Sie das Feld leer, wenn dies die erste Epoche ist.',
    ],
    'reorder'       => [],
];

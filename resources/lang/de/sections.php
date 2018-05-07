<?php

return [
    'create'        => [
        'description'   => 'Erstelle eine neue Kategorie',
        'success'       => 'Kategorie \':name\' erstellt.',
        'title'         => 'Neue Kategorie',
    ],
    'destroy'       => [
        'success'   => 'Kategorie \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Kategorie \':name\' aktualisiert.',
        'title'     => 'Bearbeite Kategorie :name',
    ],
    'fields'        => [
        'characters'    => 'Charaktere',
        'children'      => 'Kinder',
        'name'          => 'Name',
        'section'       => 'Kategorie',
        'sections'      => 'Unterkategorie',
        'type'          => 'Typ',
    ],
    'hints'         => [
        'children'  => 'Diese Liste enthält alle Objekte, die direkt in dieser Kategorie und allen Unterkategorien sind.',
        'section'   => 'Unten dargestellt sind alle Kategorien, die direkt unter dieser eingeordnet sind.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Erkundungsansicht',
        ],
        'add'           => 'Neue Kategorie',
        'description'   => 'Verwalte die Kategorie von :name.',
        'header'        => 'Kategorien von :name',
        'title'         => 'Kategorien',
    ],
    'placeholders'  => [
        'name'      => 'Name der Kategorie',
        'section'   => 'Wähle eine Elternkategorie',
        'type'      => 'Überlieferung, Geschichte, Kriege, Religion, Flaggenkunde',
    ],
    'show'          => [
        'description'   => 'Eine Detailansicht einer Kategorie',
        'tabs'          => [
            'children'      => 'Kinder',
            'information'   => 'Informationen',
            'sections'      => 'Kategorien',
        ],
        'title'         => 'Kategorie :name',
    ],
];

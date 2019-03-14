<?php

return [
    'children'      => [
        'description'   => 'Objekte mit diesem Tag',
        'title'         => 'Tag :name Subtags',
    ],
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
        'tag'           => 'Tag',
        'tags'          => 'Subtags',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested'    => 'Du kannst deine Kategorien in einer verschachtelten Ansicht ansehen. Kategorien ohne einen übergeordneten Kategorie werden direkt angezeigt. Kategorien, die untergeordnete Kategorien haben, können angeklickt werden um die untergeordneten Kategorien anzuzeigen. Du kannst so lange klicken, bis es keine untergeordneten Kategorien mehr gibt.',
    ],
    'hints'         => [
        'children'  => 'Diese Liste enthält alle Objekte, die direkt in dieser Kategorie und allen Unterkategorien sind.',
        'tag'       => 'Unten dargestellt sind alle Kategorien, die direkt unter dieser eingeordnet sind.',
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
    'new_tag'       => 'Neues Tag',
    'placeholders'  => [
        'name'  => 'Name der Kategorie',
        'tag'   => 'Wähle eine Elternkategorie',
        'type'  => 'Überlieferung, Geschichte, Kriege, Religion, Flaggenkunde',
    ],
    'show'          => [
        'description'   => 'Eine Detailansicht einer Kategorie',
        'tabs'          => [
            'children'      => 'Kinder',
            'information'   => 'Informationen',
            'tags'          => 'Kategorien',
        ],
        'title'         => 'Kategorie :name',
    ],
    'tags'          => [
        'description'   => 'Subtags',
        'title'         => 'Tag :name Subtags',
    ],
];

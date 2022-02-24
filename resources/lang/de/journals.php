<?php

return [
    'create'        => [
        'success'   => 'Logbuch erstellt.',
        'title'     => 'Erstelle ein neues Logbuch',
    ],
    'destroy'       => [
        'success'   => 'Logbuch entfernt.',
    ],
    'edit'          => [
        'success'   => 'Logbuch aktualisiert.',
        'title'     => 'Bearbeite Logbuch :name',
    ],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Datum',
        'image'     => 'Bild',
        'journal'   => 'Übergeordnetes Logbuch',
        'journals'  => 'Untergeordnetes Logbuch',
        'name'      => 'Name',
        'relation'  => 'Beziehung',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'journals'      => 'Zeigen Sie alle oder nur die direkt Untergeordneten Logbücher dieses Logbuchs an.',
        'nested_parent' => 'Anzeigen der Journale von :parent.',
        'nested_without'=> 'Anzeigen aller Journale ohne übergeordnetes Journal. Klicken Sie auf eine Zeile, um die Kinderjournale anzuzeigen.',
    ],
    'index'         => [
        'add'       => 'Neues Logbuch',
        'header'    => 'Logbücher von :name',
        'title'     => 'Logbücher',
    ],
    'journals'      => [
        'title' => 'Logbuch :name Untergeordnetes Logbuch',
    ],
    'placeholders'  => [
        'author'    => 'Wer hat das Logbuch geschrieben',
        'date'      => 'Datum des Logbuchs',
        'journal'   => 'Wähle ein übergeordnetes Logbuch',
        'name'      => 'Name des Logbuchs',
        'type'      => 'Session, One Shot, Entwurf',
    ],
    'show'          => [
        'tabs'  => [
            'journals'  => 'Logbücher',
        ],
        'title' => 'Logbuch :name',
    ],
];

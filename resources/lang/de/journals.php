<?php

return [
    'create'        => [
        'description'   => 'Erstelle ein neues Logbuch',
        'success'       => 'Logbuch erstellt.',
        'title'         => 'Erstelle ein neues Logbuch',
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
        'nested'        => 'Anzeigen von Logbüchern ohne übergeordnetetes Logbuch als erstes. Klicken Sie auf eine Zeile, um die untergordneten Logbücher des Logbuchs zu durchsuchen.',
        'nested_parent' => 'Anzeigen der Journale von :parent.',
        'nested_without'=> 'Anzeigen aller Journale ohne übergeordnetes Journal. Klicken Sie auf eine Zeile, um die Kinderjournale anzuzeigen.',
    ],
    'index'         => [
        'add'           => 'Neues Logbuch',
        'description'   => 'Verwalte die Logbücher von :name',
        'header'        => 'Logbücher von :name',
        'title'         => 'Logbücher',
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
        'description'   => 'Eine detaillierte Ansicht eines Logbuchs',
        'tabs'          => [
            'journals'  => 'Logbücher',
        ],
        'title'         => 'Logbuch :name',
    ],
];

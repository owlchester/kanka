<?php

return [
    'create'        => [
        'title' => 'Erstelle ein neues Logbuch',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Datum',
    ],
    'helpers'       => [
        'journals'          => 'Zeigen Sie alle oder nur die direkt Untergeordneten Logbücher dieses Logbuchs an.',
        'nested_without'    => 'Anzeigen aller Journale ohne übergeordnetes Journal. Klicken Sie auf eine Zeile, um die Kinderjournale anzuzeigen.',
    ],
    'index'         => [],
    'journals'      => [],
    'placeholders'  => [
        'author'    => 'Wer hat das Logbuch geschrieben',
        'date'      => 'Datum des Logbuchs',
        'type'      => 'Session, One Shot, Entwurf',
    ],
    'show'          => [],
];

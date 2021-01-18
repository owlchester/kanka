<?php

return [
    'create'        => [
        'description'   => 'Skapa en ny journal',
        'success'       => 'Journal \':name\' skapad.',
        'title'         => 'Ny Journal',
    ],
    'destroy'       => [
        'success'   => 'Journal \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Journal \':name\' uppdaterad.',
        'title'     => 'Redigera Journal :name',
    ],
    'fields'        => [
        'author'    => 'Författare',
        'date'      => 'Datum',
        'image'     => 'Bild',
        'journal'   => 'Huvudjournal',
        'journals'  => 'Underjournal',
        'name'      => 'Namn',
        'relation'  => 'Förbindelse',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'journals'  => 'Visa alla eller bara underjournalerna direkt under denna journal.',
        'nested'    => 'Visa journaler utan någon huvudjournal först. Klicka på en rad för att utforska journalens underjournaler.',
    ],
    'index'         => [
        'add'           => 'Ny Journal',
        'description'   => 'Hantera journalerna för :name.',
        'header'        => 'Journalerna för :name',
        'title'         => 'Journaler',
    ],
    'journals'      => [
        'title' => 'Journal :name underjournaler',
    ],
    'placeholders'  => [
        'author'    => 'Vem skrev journalen',
        'date'      => 'Datum i riktiga världen för journalen',
        'journal'   => 'Välj en huvudjournal',
        'name'      => 'Namn på journalen',
        'type'      => 'Speltillfälle, Engångs, Utkast',
    ],
    'show'          => [
        'description'   => 'En detaljerad vy för en journal',
        'tabs'          => [
            'journals'  => 'Journaler',
        ],
        'title'         => 'Journal :name',
    ],
];

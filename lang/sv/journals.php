<?php

return [
    'create'        => [
        'title' => 'Ny Journal',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'author'    => 'Författare',
        'date'      => 'Datum',
        'journal'   => 'Huvudjournal',
        'journals'  => 'Underjournal',
    ],
    'helpers'       => [
        'journals'  => 'Visa alla eller bara underjournalerna direkt under denna journal.',
    ],
    'index'         => [],
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
        'tabs'  => [
            'journals'  => 'Journaler',
        ],
    ],
];

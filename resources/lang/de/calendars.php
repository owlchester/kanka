<?php

return [
    'actions'       => [
        'add_month'     => 'Monat hinzufügen',
        'add_weekday'   => 'Wochentag hinzufügen',
        'add_year'      => 'Jahr hinzufügen',
    ],
    'create'        => [
        'description'   => 'Einen neuen Kalender erstellen',
        'success'       => 'Kalender \':name\' erstellt.',
        'title'         => 'Neuer Kalender',
    ],
    'destroy'       => [
        'success'   => 'Kalender \':name\' gelöscht',
    ],
    'edit'          => [
        'success'   => 'Kalender \':name\' aktualisiert',
        'title'     => 'Kalender :name bearbeiten',
    ],
    'event'         => [
        'destroy'   => 'Ereignis aus Kalender :name entfernt',
        'helpers'   => [
            'add'   => 'Füge ein bestehendes Ereignis aus der Liste hinzu.',
            'new'   => 'Oder gebe einfach einen Namen für ein neues EVent ein.',
        ],
        'modal'     => [
            'title' => 'Füge ein Event zum Kalender hinzu',
        ],
        'success'   => 'Event \':event\' zum Kalender hinzugefügt.',
    ],
    'fields'        => [
        'comment'           => 'Kommentar',
        'current_day'       => 'Aktueller Tag',
        'current_month'     => 'Aktueller Monat',
        'current_year'      => 'Aktuelles Jahr',
        'date'              => 'Aktuelles Datum',
        'has_leap_year'     => 'Hat Schaltjahre',
        'is_recurring'      => 'Wiederkehrend',
        'leap_year_amount'  => 'Tage hinzufügen',
        'leap_year_month'   => 'Monat',
        'leap_year_offset'  => 'Jedes',
        'leap_year_start'   => 'Schaltjahr',
        'months'            => 'Monate',
        'name'              => 'Name',
        'parameters'        => 'Parameter',
        'seasons'           => 'Jahreszeiten',
        'suffix'            => 'Suffix',
        'type'              => 'Typ',
        'weekdays'          => 'Wochentage',
    ],
    'hints'         => [
        'is_recurring'  => 'Ein Event kann wiederkehrend sein. Es wird dann jedes Jahr am gleichen Tag erscheinen.',
    ],
    'index'         => [
        'add'           => 'Neuer Kalender',
        'description'   => 'Verwalte die Kalender von :name',
        'header'        => 'Kalender von :name',
        'title'         => 'Kalender',
    ],
    'panels'        => [
        'leap_year' => 'Schaltjahr',
        'years'     => 'Benamte Jahre',
    ],
    'parameters'    => [
        'month' => [
            'length'    => 'Anzahl der Tage',
            'name'      => 'Monatsname',
        ],
        'year'  => [
            'name'      => 'Name',
            'number'    => 'Jahr',
        ],
    ],
    'placeholders'  => [
        'comment'           => 'Geburtstag, Volksfest, Sonnenwende',
        'date'              => 'Das aktuelle Datum',
        'leap_year_amount'  => 'Anzahl der Tage, die bei einem Schaltjahr hinzugefügt werden',
        'leap_year_month'   => 'Monat, in dem die Tage hinzugefügt werden',
        'leap_year_offset'  => 'Alle wieviele Jahre ist Schaltjahr',
        'leap_year_start'   => 'Erstes Jahr, das ein Schaltjahr ist',
        'months'            => 'Anzahl der Monate in einem Jahr',
        'name'              => 'Name des Kalenders',
        'seasons'           => 'Anzahl der Jahrezeiten',
        'suffix'            => 'Aktueller Suffix der Ära (v. Chr., n. Chr.)',
        'type'              => 'Art des Kalenders',
        'weekdays'          => 'Anzahl der Tage in einer Woche',
    ],
    'show'          => [
        'description'   => 'Eine Detailansicht eines Kalenders',
        'tabs'          => [
            'information'   => 'Information',
        ],
        'title'         => 'Kalender :name',
    ],
];

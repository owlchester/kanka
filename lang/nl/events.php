<?php

return [
    'create'        => [
        'title' => 'Nieuwe gebeurtenis',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [],
    'fields'        => [
        'date'  => 'Datum',
    ],
    'helpers'       => [
        'date'  => 'Dit veld kan alles bevatten en is niet gekoppeld aan de kalenders van de campaign. Om deze gebeurtenis aan een kalender te koppelen, voeg je deze toe aan de kalender of op het tabblad herinneringen van deze gebeurtenissen.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Een datum voor je gebeurtenis',
        'type'  => 'Ceremonie, Festival, Ramp, Veldslag, Geboorte',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Kalender Invoeren',
    ],
];

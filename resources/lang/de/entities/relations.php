<?php

return [
    'create'        => [
        'success'   => 'Beziehung für :name hinzugefügt.',
        'title'     => 'Beziehung erstellen',
    ],
    'destroy'       => [
        'success'   => 'Beziehung für :name entfernt',
    ],
    'fields'        => [
        'attitude'  => 'Einstellung',
        'is_star'   => 'Fixiert',
        'relation'  => 'Beziehung',
        'target'    => 'Ziel',
        'two_way'   => 'Gespiegelte Beziehung erstellen',
    ],
    'hints'         => [
        'mirrored'  => [
            'text'  => 'Diese Beziehung ist gespiegelt mit :link.',
            'title' => 'Gespiegelt',
        ],
        'two_way'   => 'Wenn du eine gespiegelte Beziehung erstellst, wird die gleiche Beziehung auch auf dem Ziel erstellt. Wenn du diese später editierst, wird die gespiegelte Beziehung nicht aktualisiert.',
    ],
    'placeholders'  => [
        'attitude'  => '-100 bis 100, 100 ist maximal positiv.',
        'relation'  => 'Art der Beziehung',
        'target'    => 'Wähle ein Objekt',
    ],
    'update'        => [
        'success'   => 'Beziehung für :name aktualisiert',
        'title'     => 'Beziehungen aktualisieren',
    ],
];

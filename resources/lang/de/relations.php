<?php

return [
    'create'        => [
        'success'   => 'Beziehung für :name hinzugefügt.',
        'title'     => 'Beziehung erstellen',
    ],
    'destroy'       => [
        'success'   => 'Beziehung für :name entfernt',
    ],
    'edit'          => [
        'success'   => 'Beziehung für :name aktualisiert',
        'title'     => 'Beziehungen aktualisieren',
    ],
    'fields'        => [
        'relation'  => 'Beziehung',
        'target'    => 'Ziel',
        'two_way'   => 'Gespiegelte Beziehung erstellen',
    ],
    'hints'         => [
        'two_way'   => 'Wenn du eine gespiegelte Beziehung erstellst, wird die gleiche Beziehung auch auf dem Ziel erstellt. Wenn du diese später editierst, wird die gespiegelte Beziehung nicht aktualisiert.',
    ],
    'placeholders'  => [
        'relation'  => 'Art der Beziehung',
        'target'    => 'Wähle ein Objekt',
    ],
];

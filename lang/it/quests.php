<?php

return [
    'create'        => [
        'title' => 'Nuova Missione',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character'     => 'Istigatore',
        'date'          => 'Data',
        'is_completed'  => 'Completata',
        'role'          => 'Ruolo',
    ],
    'helpers'       => [],
    'hints'         => [
        'quests'    => 'Una ragnatela di missioni interconnesse può essere costruita utilizzando il campo "Missione Padre".',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Data del mondo reale per la missione',
        'role'  => 'Il ruolo dell\'entità nella missione',
        'type'  => 'Personaggio, Missione Secondaria, Missione Principale',
    ],
    'show'          => [],
];

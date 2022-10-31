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
        'quest'         => 'Missione Padre',
        'quests'        => 'Sotto-Missioni',
        'role'          => 'Ruolo',
    ],
    'helpers'       => [],
    'hints'         => [
        'quests'    => 'Una ragnatela di missioni interconnesse può essere costruita utilizzando il campo "Missione Padre".',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Data del mondo reale per la missione',
        'name'  => 'Nome della missione',
        'quest' => 'Missione Padre',
        'role'  => 'Il ruolo dell\'entità nella missione',
        'type'  => 'Personaggio, Missione Secondaria, Missione Principale',
    ],
    'show'          => [],
];

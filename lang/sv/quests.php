<?php

return [
    'create'        => [
        'title' => 'Nytt Uppdrag',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character'     => 'Anstiftare',
        'copy_elements' => 'Kopiera element fästa till uppdraget',
        'date'          => 'Datum',
        'is_completed'  => 'Avslutat',
        'quest'         => 'Huvuduppdrag',
        'quests'        => 'Underuppdrag',
        'role'          => 'Roll',
    ],
    'helpers'       => [],
    'hints'         => [
        'quests'    => 'Ett nätt av sammankopplade uppdrag kan byggas genom att använda Huvuduppdrag fältet.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Verklig världs datum för uppdraget',
        'name'  => 'Namn på uppdraget',
        'quest' => 'Huvuduppdrag',
        'role'  => 'Denna entitets roll i uppdraget',
        'type'  => 'Karaktärsark, Sidouppdrag, Primärt',
    ],
    'show'          => [],
];

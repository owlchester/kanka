<?php

return [
    'create'        => [
        'success'   => 'Uppdrag \':name\' skapat.',
        'title'     => 'Nytt Uppdrag',
    ],
    'destroy'       => [
        'success'   => 'Uppdrag \':name\' borttaget.',
    ],
    'edit'          => [
        'success'   => 'Uppdrag \':name\' uppdaterat.',
        'title'     => 'Redigera Uppdrag :name',
    ],
    'fields'        => [
        'character'     => 'Anstiftare',
        'copy_elements' => 'Kopiera element fästa till uppdraget',
        'date'          => 'Datum',
        'description'   => 'Beskrivning',
        'image'         => 'Bild',
        'is_completed'  => 'Avslutat',
        'name'          => 'Namn',
        'quest'         => 'Huvuduppdrag',
        'quests'        => 'Underuppdrag',
        'role'          => 'Roll',
        'type'          => 'Typ',
    ],
    'helpers'       => [],
    'hints'         => [
        'quests'    => 'Ett nätt av sammankopplade uppdrag kan byggas genom att använda Huvuduppdrag fältet.',
    ],
    'index'         => [
        'title' => 'Uppdrag',
    ],
    'placeholders'  => [
        'date'  => 'Verklig världs datum för uppdraget',
        'name'  => 'Namn på uppdraget',
        'quest' => 'Huvuduppdrag',
        'role'  => 'Denna entitets roll i uppdraget',
        'type'  => 'Karaktärsark, Sidouppdrag, Primärt',
    ],
    'show'          => [],
];

<?php

return [
    'create'        => [
        'success'       => 'Uppdrag \':name\' skapat.',
        'title'         => 'Nytt Uppdrag',
    ],
    'destroy'       => [
        'success'   => 'Uppdrag \':name\' borttaget.',
    ],
    'edit'          => [
        'success'       => 'Uppdrag \':name\' uppdaterat.',
        'title'         => 'Redigera Uppdrag :name',
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
    'helpers'       => [
        'nested'    => 'I Hierarkisk Vy kan du se dina uppdrag i hierarkisk ordning. Uppdrag utan ett huvuduppdrag kommer visas som standard. Uppdrag med underuppdrag kan klickas på för att visa dessa. Du kan fortsätta klicka tills det inte finns fler underuppdrag.',
    ],
    'hints'         => [
        'quests'    => 'Ett nätt av sammankopplade uppdrag kan byggas genom att använda Huvuduppdrag fältet.',
    ],
    'index'         => [
        'add'           => 'Nytt Uppdrag',
        'header'        => 'Uppdrag för :name',
        'title'         => 'Uppdrag',
    ],
    'placeholders'  => [
        'date'  => 'Verklig världs datum för uppdraget',
        'name'  => 'Namn på uppdraget',
        'quest' => 'Huvuduppdrag',
        'role'  => 'Denna entitets roll i uppdraget',
        'type'  => 'Karaktärsark, Sidouppdrag, Primärt',
    ],
    'show'          => [
        'actions'       => [
        ],
        'tabs'          => [
            'characters'    => 'Karaktärer',
            'information'   => 'Information',
            'items'         => 'Föremål',
            'locations'     => 'Platser',
            'organisations' => 'Organisationer',
            'quests'        => 'Uppdrag',
        ],
        'title'         => 'Uppdrag :name',
    ],
];

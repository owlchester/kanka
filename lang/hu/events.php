<?php

return [
    'create'        => [
        'title' => 'Új esemény',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'title' => ':name esemény',
    ],
    'fields'        => [
        'date'      => 'Dátum',
        'event'     => 'Szülő esemény',
        'events'    => 'Események',
    ],
    'helpers'       => [
        'date'              => 'Ebbe a mezőbe bármit beírhatsz, és nem kapcsolódik a kampány naptárához. Hogy az eseményt összerendeld egy naptárral, magán a naptáron add hozzá az eseményt, vagy ennek az eseménynek az Emlékeztetők fülén.',
        'nested_without'    => 'Minden eseményt megmutat, amelyeknek nincs szülőeseménye. Klikkelj egy sorra, hogy meglásd a gyermekeseményeket.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Az eseményed dátuma',
        'name'  => 'Az esemény neve',
        'type'  => 'Szertartás, ünnepség, katasztrófa, csata, születés',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Naptári bejegyzések',
    ],
];

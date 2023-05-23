<?php

return [
    'create'        => [
        'title' => 'Új esemény',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [],
    'fields'        => [
        'date'  => 'Dátum',
    ],
    'helpers'       => [
        'date'              => 'Ebbe a mezőbe bármit beírhatsz, és nem kapcsolódik a kampány naptárához. Hogy az eseményt összerendeld egy naptárral, magán a naptáron add hozzá az eseményt, vagy ennek az eseménynek az Emlékeztetők fülén.',
        'nested_without'    => 'Minden eseményt megmutat, amelyeknek nincs szülőeseménye. Klikkelj egy sorra, hogy meglásd a gyermekeseményeket.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Az eseményed dátuma',
        'type'  => 'Szertartás, ünnepség, katasztrófa, csata, születés',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Naptári bejegyzések',
    ],
];
